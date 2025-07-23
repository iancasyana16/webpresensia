<?php

namespace App\Http\Controllers\Api;

use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\IdCard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class IdCardController extends Controller
{
    /**
     * Endpoint untuk mendaftarkan RFID baru atau memproses absensi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processRfidScan(Request $request)
    {
        // Pastikan permintaan memiliki 'uid'
        $request->validate(
            [
                'uid' => 'required|string|max:255',
            ]
        );

        $rfidUid = $request->input('uid');
        Log::info("Received attendance scan request for UID: " . $rfidUid);

        // 1. Cari IdCard berdasarkan UID
        $idcard = IdCard::where('uid', $rfidUid)->first();

        // --- Logika Registrasi Kartu Baru ---
        if (!$idcard) {
            try {
                $newCard = IdCard::create(
                    [
                        'uid' => $request->uid,
                        'status' => 'tidak_aktif', // Pastikan status awal saat registrasi
                    ]
                );
                Log::info("New RFID card registered: " . $rfidUid);

                return response()->json([
                    'status' => 'info',
                    'action' => 'kartu_baru_terdaftar', // Gunakan snake_case untuk konsistensi
                    'message' => 'Kartu RFID ini baru terdaftar. Harap daftarkan dengan siswa.',
                    'data' => $newCard->toArray() // Kirim dalam bentuk array
                ], 201); // 201 Created untuk sumber daya baru
            } catch (\Exception $e) {
                Log::error("Failed to register new RFID card: " . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'action' => 'registration_failed',
                    'message' => 'Gagal mendaftarkan kartu RFID baru: ' . $e->getMessage(),
                ], 500);
            }
        }

        // --- Logika Cek Status IdCard (Aktif/Tidak Aktif) ---
        // Asumsi 'status' di tabel id_cards bisa 'aktif' atau 'tidak_aktif'
        if ($idcard->status === 'tidak_aktif') {
            Log::warning("RFID card " . $rfidUid . " (ID: " . $idcard->id . ") is not active.");
            return response()->json([
                'status' => 'warning',
                'action' => 'kartu_belum_aktif',
                'message' => 'Kartu RFID ini tidak aktif. Silakan hubungi admin.',
                'data' => $idcard->toArray()
            ], 403); // 403 Forbidden
        }

        // --- Logika Asosiasi Siswa dengan IdCard ---
        $siswa = Siswa::where('id_idCard', $idcard->id)->first();

        if (!$siswa) {
            // IdCard terdaftar dan aktif, tapi belum diasosiasikan dengan Siswa
            Log::warning("RFID card " . $rfidUid . " (ID: " . $idcard->id . ") is registered but not associated with any student.");
            return response()->json([
                'status' => 'warning',
                'action' => 'siswa_belum_terhubung', // Lebih deskriptif
                'message' => 'Kartu RFID aktif belum terhubung dengan siswa. Harap hubungi admin.',
                'data' => $idcard->toArray()
            ], 200); // 200 OK karena status warning, bukan error
        }

        // --- Logika Proses Absensi ---
        try {
            $now = Carbon::now();
            $today = $now->toDateString(); // Mengambil tanggal saja (YYYY-MM-DD)

            // Dapatkan absensi terakhir siswa untuk hari ini
            $lastAttendance = Kehadiran::where('id_siswa', $siswa->id)
                ->whereDate('waktu_tap', $today)
                ->latest('waktu_tap')
                ->first();

            $attendanceType = 'masuk'; // Default untuk absensi pertama kali
            $attendanceStatus = 'hadir'; // Default status

            if ($lastAttendance) {
                // Ada absensi sebelumnya untuk hari ini
                if ($lastAttendance->type === 'masuk') {
                    // Absensi terakhir adalah 'masuk', jadi tap berikutnya adalah 'pulang'
                    $attendanceType = 'pulang';
                } else {
                    // Absensi terakhir adalah 'pulang'
                    // Berarti siswa sudah absen pulang. Abaikan tap berikutnya.
                    Log::info("Siswa " . $siswa->nama_siswa . " sudah melakukan tap pulang hari ini. Tap diabaikan.");
                    return response()->json([
                        'status' => 'info',
                        'action' => 'sudah_pulang', // Lebih jelas
                        'message' => "{$siswa->nama_siswa} sudah absen pulang hari ini. Tap diabaikan.",
                        'siswa_name' => $siswa->nama_siswa,
                        'last_attendance_type' => $lastAttendance->type, // Ambil tipe terakhir yang benar
                        'waktu_tap' => $now->toDateTimeString(), // Waktu tap saat ini
                    ], 200);
                }
            }
            // Jika $lastAttendance null, maka $attendanceType tetap 'masuk' (default)

            // Optional: Logic untuk menentukan status 'terlambat'
            // Asumsi jam masuk sekolah adalah 07:30 WIB
            // Pastikan zona waktu Laravel di config/app.php sudah 'Asia/Jakarta'
            $jamMasukSekolah = Carbon::createFromTimeString('07:30:00', 'Asia/Jakarta');
            if ($attendanceType === 'masuk' && $now->greaterThan($jamMasukSekolah)) {
                $attendanceStatus = 'izin'; // Menggunakan 'terlambat' sesuai diskusi
                Log::info("Siswa " . $siswa->nama_siswa . " tercatat terlambat.");
            }

            // return response()->json($siswa);
            // Catat absensi baru
            $kehadiran = Kehadiran::create([
                'id_siswa' => $siswa->id,
                'uid_rfid' => $rfidUid,
                'waktu_tap' => $now,
                'type' => $attendanceType,
                'status' => $attendanceStatus,
                'id_guru' => $siswa->Walikelas->id ?? null, // Asumsi id_guru ada di model Siswa
                'id_perekam' => null,
            ]);

            // return response()->json($kehadiran);

            Log::info("Attendance recorded for student " . $siswa->nama_siswa . " (ID: " . $siswa->id . ") - Type: " . $attendanceType . ", Status: " . $attendanceStatus);

            return response()->json([
                'status' => 'success',
                'action' => 'absen_tercatat', // Lebih jelas
                'message' => "Absensi {$attendanceType} untuk {$siswa->nama_siswa} berhasil dicatat!",
                'siswa_name' => $siswa->nama_siswa,
                'attendance_type' => $attendanceType,
                'waktu_tap' => \Carbon\Carbon::parse($kehadiran->waktu_tap)->toDateTimeString(), // Output dalam format WIB
                'attendance_status' => $attendanceStatus,
                'data' => $kehadiran->toArray() // Kirim model yang baru dibuat
            ], 200);
        } catch (\Exception $e) {
            Log::error("Failed to record attendance for student " . $siswa->nama_siswa . " (ID: " . $siswa->id . "): " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'action' => 'attendance_failed',
                'message' => 'Gagal mencatat absensi: ' . $e->getMessage(),
            ], 500);
        }
    }
}