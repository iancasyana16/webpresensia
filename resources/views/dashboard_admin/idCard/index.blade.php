@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')
    <div class="container p-3 min-h-screen bg-gray-100">
        <div class="p-3">
            <x-toast />
            <div class="p-5 bg-white rounded-lg shadow-md mb-3 items-center flex justify-between">
                <h1 class="text-2xl font-bold">{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div class="flex justify-end items-center mb-3">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                        <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <input type="search" name="search" id="search" placeholder="Pencarian" oninput="handleSearchChange()" value="{{ request('search') }}"
                        class="border border-gray-300 bg-white rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>
            </div>
            <div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
                <table class="min-w-full divide-y divide-gray-200 border rounded-lg">
                    <thead class="bg-sky-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                UID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Opsi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($idCards as $index => $idCard)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $idCards->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $idCard->uid }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $idCard->status == 'aktif' ? 'bg-green-300 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $idCard->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    <button type="button" onclick="openDeleteModal({{ $idCard->id }})"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-800 font-bold ml-2 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada data ID Card.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $idCards->links('components.pagination') }}
            </div>
            <div id="modalDelete"
                class="fixed inset-0 backdrop-blur-xs bg-opacity-50 items-center justify-center z-50 hidden">
                <div class="bg-white rounded-xl p-3 w-full max-w-sm shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-30 text-red-500 mb-4 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                    </svg>
                    <h2 class="text-lg text-center font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
                    <p class="text-sm text-center font-semibold text-gray-800 mb-4">Apakah Anda yakin ingin menghapus data
                        ID Card ini?</p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-center gap-3">
                            <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 bg-gray-300 rounded cursor-pointer hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer hover:bg-red-700">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('modalDelete');
            const form = document.getElementById('deleteForm');
            form.action = `/delete-idCard/${id}`;
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