@extends('layouts.dashboard_guru')
@section('title', 'Dashboard Siswa')
@section('content')
    <div class="container p-5">
        <h2 class="text-2xl font-bold mb-4 bg-white p-3 shadow-2xl rounded-xl">
            Daftar Absensi Siswa
        </h2>
        @if (session('success'))
            <div id="successToast"
                class="fixed top-5 right-5 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded shadow-lg flex items-center gap-2 animate-fade-in-down">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button onclick="document.getElementById('successToast').remove()"
                    class="ml-4 text-green-700 hover:text-red-600 font-bold">&times;</button>
            </div>
        @endif
        @if (isset($message))
            <div class="mb-4 p-3 bg-white rounded shadow">
                {{ $message }}
            </div>
        @else
            <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
                <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                    <thead class="bg-sky-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-white tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-white tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-white tracking-wider">Nama Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-white tracking-wider">Gender</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-white tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-white tracking-wider">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($siswas as $index => $siswa)
                            @php
        $absen = $kehadiranMap->get($siswa->id);
                            @endphp
                            <tr class="hover:bg-gray-50" id="siswa-{{ $siswa->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->nis }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->nama_siswa }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->gender }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center status-absen">
                                    @if ($absen)
                                        <span class="text-green-500 font-semibold bg-green-200 px-2 py-1 rounded">
                                            {{ $absen->status }}
                                        </span>
                                    @else
                                        <span class="text-red-500 font-semibold bg-red-200 px-2 py-1 rounded">
                                            Belum Absen
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex justify-center aksi-absen">
                                    @if ($absen)
                                        -
                                    @else
                                        <button
                                            class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-200 flex gap-2 aksi-absen"
                                            onclick="window.location.href='{{ route('create-absen', ['id' => $siswa->id]) }}'">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="size-6">
                                                <path fill-rule="evenodd"
                                                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <span class="font-semibold">Absen</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center px-6 py-4 text-gray-500 italic">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        Pusher.logToConsole = true;

            var pusher = new Pusher('9e1fb5d97e3540f860c2', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('siswa-absen');
            channel.bind('SiswaTelahAbsen', function (data) {
                console.log('Data Siswa Absen:', data);

                var row = document.getElementById('siswa-' + data.siswa.id);
                if (row) {
                    console.log('Baris ditemukan:', row);

                    // Update status absen
                    var statusCell = row.querySelector('.status-absen');
                    if (statusCell) {
                        var span = statusCell.querySelector('span');
                        if (span) {
                            span.textContent = 'Hadir';
                            span.classList.remove('text-red-500', 'bg-red-200');
                            span.classList.add('text-green-600', 'bg-green-200');
                        }
                    }

                    // Hilangkan tombol aksi absen
                    var aksiCell = row.querySelector('.aksi-absen');
                    if (aksiCell) {
                        aksiCell.innerHTML = '-';
                    }

                } else {
                    console.warn('Tidak ditemukan baris siswa ID:', data.siswa.id);
                }
            });
    </script>
@endpush