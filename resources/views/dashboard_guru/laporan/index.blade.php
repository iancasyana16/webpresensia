@extends('layouts.dashboard_guru')
@section('title', 'Rekap Kehadiran Siswa')
@section('content')
    <div class="container p-5">
        <h2 class="text-2xl font-bold mb-4 bg-white p-3 shadow-2xl rounded-xl">
            Laporan Kehadiran Siswa
        </h2>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
                {{ session('success') }}
            </div>
        @endif
        <!-- <div class="bg-white shadow-2xl p-5 rounded-xl">
                    <p class="text-center text-gray-700 mb-4">Wali Kelas: <span class="font-semibold">{{ $guru->nama_guru }}</span></p>

                    @foreach($rekapBulanan as $bulan => $data)
                        <div class="mb-10">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-lg font-semibold text-gray-800">Bulan {{ $bulan }}/{{ $tahun }}</h3>
                                <a href="{{ route('rekap.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 text-sm rounded">
                                    📥 Download PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div> -->
        <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
            <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                <thead class="bg-sky-800">
                    <tr class="text-white">
                        <!-- <th class="px-6 py-3 text-left text-sm font-semibold">No</th> -->
                        <th class="px-6 py-3 text-left text-sm font-semibold">Waktu / Tanggal</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-semibold">View</th> -->
                        <th class="px-6 py-3 text-center text-sm font-semibold">Pdf</th>
                        <!-- <th class="px-6 py-3 text-center text-sm font-semibold">Opsi</th> -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($rekapBulanan as $bulan => $data)
                        <tr>
                            <!-- <td class="px-6 py-4 text-md">{{ $bulan}}</td> -->
                            <!-- <td class="px-6 py-4 text-sm">{{ $izin->siswa->nama_siswa ?? '-' }}</td> -->
                            <td class="px-6 py-4 text-md">Periode Bulan {{ $bulan }} - {{ $tahun }}
                            </td>
                            <!-- <td class="px-6 py-4 text-sm">
                                                <a href="{{ route('preview-pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}?preview=true"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 text-sm rounded">
                                                    📥 Preview PDF
                                                </a>
                                            </td> -->
                            <td class="px-6 py-4 text-sm flex justify-center gap-1">
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-200 flex gap-2"
                                    onclick="window.location.href='{{ route('download-pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path fill-rule="evenodd"
                                            d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v4.19l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V10.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold">Download PDF</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500 italic">Belum ada data izin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection