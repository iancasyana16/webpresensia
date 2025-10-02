<?php

namespace App\Http\Controllers\Api;

use App\Models\Siswa;
use App\Models\IdCard;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\SiswaAbsenEvent;
use App\Http\Controllers\Controller;

class AbsensiRfidController extends Controller
{
    public function processRfidScan(Request $request)
    {
        $request->validate(['uid' => 'required|string|max:255']);
        $uid = $request->input('uid');

        // Cek apakah kartu RFID sudah terdaftar
        $idcard = IdCard::where('uid', $uid)->first();
        if (!$idcard) {
            return $this->registerNewCard($uid);
        }

        if ($idcard->status === 'tidak aktif') {
            return $this->respond('warning', 'kartu belum aktif', 'Kartu RFID ini tidak aktif. Hubungi admin.', 403, $idcard);
        }

        $siswa = Siswa::where('id_card', $idcard->id)->first();
        if (!$siswa) {
            return $this->respond('warning', 'siswa belum terhubung', 'Kartu belum terhubung dengan siswa. Hubungi admin.', 200, $idcard);
        }

        return $this->prosesAbsensi($siswa, $uid);
    }

    private function registerNewCard(string $uid)
    {
        try {
            $newCard = IdCard::create([
                'uid' => $uid,
                'status' => 'tidak aktif',
            ]);

            return $this->respond('info', 'kartu baru terdaftar', 'Kartu berhasil terdaftar.', 201, $newCard);
        } catch (\Exception $e) {
            return $this->respond('error', 'registrasi gagal', 'Gagal mendaftarkan kartu.', 500);
        }
    }

    private function prosesAbsensi(Siswa $siswa, string $uid)
    {
        try {
            $now = Carbon::now();
            $today = $now->toDateString();

            // Cek apakah sudah absen hari ini
            $sudahAbsen = Kehadiran::where('id_siswa', $siswa->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if ($sudahAbsen) {
                return $this->respond('info', 'sudah absen', "{$siswa->nama_siswa} sudah absen hari ini. Tap diabaikan.", 200);
            }

            // Batas waktu absen masuk
            $batasMasuk = Carbon::createFromTimeString('23:00:00', 'Asia/Jakarta');
            if ($now->greaterThan($batasMasuk)) {
                return $this->respond('denied', 'hubungi guru', "{$siswa->nama_siswa} tidak bisa absen karena sudah lewat jam 07:00.", 403);
            }

            // Simpan absensi
            $absen = Kehadiran::create([
                'id_siswa' => $siswa->id,
                'uid_rfid' => $uid,
                'tanggal' => $now,
                'id_semester' => $siswa->semester->id ?? null,
                'status' => 'hadir',
            ]);

            broadcast(new SiswaAbsenEvent($siswa));

            return response()->json([
                'status' => 'success',
                'action' => 'absen tercatat',
                'message' => "Absensi berhasil untuk {$siswa->nama_siswa}.",
                'data' => [
                    'id_siswa' => $siswa->id,
                    'id_card_uid' => $siswa->idCard->uid ?? null,
                    'nama_siswa' => $siswa->nama_siswa,
                    'uid_rfid' => $uid,
                    'tanggal' => $absen->tanggal->toDateTimeString(),
                    'status' => $absen->status,
                ],
            ], 200);

        } catch (\Exception $e) {
            return $this->respond('error', 'absen gagal', $e->getMessage(), 500);
        }
    }

    private function respond(string $status, string $action, string $message, int $code = 200, $data = null)
    {
        $response = compact('status', 'action', 'message');
        if ($data) {
            $response['data'] = $data;
        }
        return response()->json($response, $code);
    }
}