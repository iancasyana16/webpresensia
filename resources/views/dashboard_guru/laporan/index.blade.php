@extends('layouts.dashboard_guru')
@section('title', 'Rekap Kehadiran Siswa')
@section('content')
        <div class="container p-5">
            <div class="mb-3 bg-white p-3 shadow-2xl rounded-lg">
                <h2 class="text-2xl font-bold mb-2">
                    Rekap Kehadiran Siswa Kelas {{ $guru->kelas->nama }}
                </h2>
                <span class="text-base font-bold text-gray-600">
                    Wali Kelas : {{ $guru->nama }}
                </span> <br>
                <span class="text-base font-bold text-gray-600">
                    Semester : {{ $semesterAktif }}
                </span> <br>
                <span class="text-base font-bold text-gray-600">
                    Bulan {{ \Carbon\Carbon::create($tahun, $bulanSekarang, 1)->translatedFormat('F') }} - Tahun {{ $tahun }}
                </span>
            </div>

            <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white mb-4">
                <table class="min-w-full divide-y divide-gray-200 rounded-lg text-center">
                    <thead class="bg-sky-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold text-left">No</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left">NIS</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left">Nama Siswa</th>
                            <th class="px-6 py-3 text-sm font-semibold">Hadir</th>
                            <th class="px-6 py-3 text-sm font-semibold">Izin</th>
                            <th class="px-6 py-3 text-sm font-semibold">Alpha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($rekapBulanan as $rekap)
                            <tr>
                                <td class="px-6 py-4 text-md text-left font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-md text-left font-medium">
                                    {{ $rekap['nis'] }}
                                </td>
                                <td class="px-6 py-4 text-md text-left font-medium">
                                    {{ $rekap['nama'] }}
                                </td>
                                <td class="px-6 py-4 text-md font-bold">
                                    {{ $rekap['hadir'] }}
                                </td>
                                <td class="px-6 py-4 text-md font-bold">
                                    {{ $rekap['izin'] }}
                                </td>
                                <td class="px-6 py-4 text-md font-bold">
                                    {{ $rekap['alpha'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center px-6 py-4 text-gray-500 italic">
                                    Belum ada data kehadiran bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    <div class="flex justify-end gap-2">
        <button
            class="bg-blue-600 text-white font-bold px-6 py-2 rounded hover:bg-blue-700 transition duration-200 flex gap-2"
            onclick="window.location.href='{{ route('download-rekap-bulanan', ['semester' => $semesterAktif, 'bulan' => $bulanSekarang, 'tahun' => $tahun]) }}'">
            Download Rekap Bulanan
        </button>
        <button
            class="bg-blue-600 text-white font-bold px-6 py-2 rounded hover:bg-blue-700 transition duration-200 flex gap-2"
            onclick="window.location.href='{{ route('download-rekap-semester', ['semester' => $semesterAktif, 'tahun' => $tahun]) }}'">
            Download Rekap Semester
        </button>
    </div>

        </div>
@endsection