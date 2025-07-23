@extends('layouts.dashboard_guru')
@section('title', 'Data Izin Siswa')
@section('content')
    <div class="container p-5">
        <h2 class="text-2xl font-bold mb-4 bg-white p-3 shadow-2xl rounded-xl">Daftar Izin Siswa</h2>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
                {{ session('success') }}
            </div>
        @endif
        <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
            <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                <thead class="bg-sky-800">
                    <tr class="text-white">
                        <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Opsi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($izins as $index => $izin)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm">{{ $izin->siswa->nama_siswa ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if ($izin->status == 'diterima')
                                    <span class="text-green-600 bg-green-200 p-1 rounded font-semibold">Disetujui</span>
                                @elseif ($izin->status == 'ditolak')
                                    <span class="text-red-600 bg-red-200 p-1 rounded font-semibold">Ditolak</span>
                                @elseif ($izin->status == 'pending')
                                    <span class="text-yellow-600 bg-yellow-200 p-1 rounded font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm flex justify-center gap-1">
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-200 flex gap-2"
                                    onclick="window.location.href='{{ route('dashboard-guru-izin-detail', $izin->id) }}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold">Detail</span>
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