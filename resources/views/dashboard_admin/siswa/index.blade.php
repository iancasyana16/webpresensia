@extends('layouts.dashboard_admin')

@section('title', config('app.name') . ' | Admin')

@section('content')
    <div class="container p-3 min-h-screen bg-gray-100">

        <div class="p-3">

            <x-modal.toast />

            <x-title>
                {{ $title ?? 'Dashboard' }}
            </x-title>

            <div class="flex justify-between items-center mb-3">
                <x-button-add href="{{ route('create-siswa') }}">
                    Input Siswa Baru
                </x-button-add>

                <x-search name="search" id="search" placeholder="Cari Siswa..." oninput="handleSearchChange()" />
            </div>

            <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
                <x-table.body>
                    <x-slot:head>
                        <x-table.th>No</x-table.th>
                        <x-table.th>NIS</x-table.th>
                        <x-table.th>Nama Siswa</x-table.th>
                        <x-table.th>Gender</x-table.th>
                        <x-table.th>Kelas</x-table.th>
                        <x-table.th>Wali Kelas</x-table.th>
                        <x-table.th>ID Card</x-table.th>
                        <x-table.th>Opsi</x-table.th>
                    </x-slot:head>

                    <x-slot:body>
                        @forelse ($siswas as $index => $siswa)
                            <x-table.tr>
                                <x-table.td>{{ $siswas->firstItem() + $index }}</x-table.td>
                                <x-table.td>{{ $siswa->nis }}</x-table.td>
                                <x-table.td>{{ $siswa->nama }}</x-table.td>
                                <x-table.td>{{ $siswa->gender }}</x-table.td>
                                <x-table.td>{{ $siswa->kelas->nama }}</x-table.td>
                                <x-table.td>{{ $siswa->kelas->guru->nama }}</x-table.td>
                                <x-table.td>{{ optional($siswa->idCard)->uid ?? '-' }}</x-table.td>
                                <x-table.td>
                                    <x-button.edit href="{{ route('edit-siswa', $siswa->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </x-button.edit>

                                    <x-button.delete :action="route('delete-siswa', $siswa->id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </x-button.delete>
                                </x-table.td>
                            </x-table.tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Tidak ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </x-slot:body>
                </x-table.body>
            </div>

            <div class="mt-3">
                {{ $siswas->links('components.pagination') }}
            </div>
        </div>
    </div>

    <x-modal.delete />

    <script>
        function handleSearchChange() {
                const query = document.getElementById('search').value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);

                // Gunakan history.pushState agar URL berubah tanpa reload (opsional)
                window.location.href = url.toString();
            }
    </script>
@endsection