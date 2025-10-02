@extends('layouts.dashboard_admin')

@section('title', config('app.name') . ' | Admin')

@section('content')
    <div class="container p-3 min-h-screen bg-gray-100">
        <div class="p-3">
            <x-modal.toast />
            <x-title>
                {{ $title ?? 'Dashboard'}}
            </x-title>
            <div class="flex justify-between items-center mb-3">

                <x-button-add href="{{ route('create-angkatan') }}">
                    Input Angkatan Baru
                </x-button-add>

                <x-search name="search" id="search" placeholder="Cari Angkatan..." oninput="handleSearchChange()" />

                <!-- <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                        <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <input type="search" name="search" id="search" placeholder="Pencarian" oninput="handleSearchChange()"
                        value="{{ request('search') }}"
                        class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 bg-white">
                </div> -->
            </div>
            <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
                <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                    <thead class="bg-sky-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white tracking-wider">Nama Angkatan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white tracking-wider">Tahun Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white tracking-wider">Tahun Selesai</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($angkatans as $angkatan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $angkatan->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $angkatan->mulai }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $angkatan->selesai }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 cursor-pointer">
                                        <a href="{{ route('edit-angkatan', $angkatan->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $angkatan->id }})"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-800 font-bold ml-2 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('naik-kelas', $angkatan->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau menaikkan kelas semua siswa angkatan ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Naik Kelas
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('modalDelete');
            const form = document.getElementById('deleteForm');
            form.action = `/delete-angkatan/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeDeleteModal() {
            document.getElementById('modalDelete').classList.add('hidden');
        }
        function handleSearchChange() {
            const query = document.getElementById('search').value;
            const url = new URL(window.location.href);
            url.searchParams.set('search', query);

            // Gunakan history.pushState agar URL berubah tanpa reload (opsional)
            window.location.href = url.toString();
        }
    </script>
@endsection