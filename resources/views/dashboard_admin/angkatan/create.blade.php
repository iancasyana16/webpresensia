@extends('layouts.dashboard_admin')

@section('title', 'Tambah Angkatan')

@section('content')
    <div class="container min-h-screen scroll p-3 bg-gray-100">

    <div class="p-3">

    <div class="p-5 bg-white rounded-lg shadow-md mb-3 items-center flex justify-between">
        <h1 class="text-2xl font-bold">
            {{ $title ?? 'Dashboard' }}
        </h1>
    </div>
    <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">
        <form action="{{ route('angkatan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-md font-bold">Nama Angkatan</label>
                <input type="text" name="nama" class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div class="mb-3">
                <label for="mulai">Tahun Mulai</label>
                <input class="border-gray-100 bg-white p-2 w-full rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" type="date" name="mulai" id="mulai" value="{{ old('mulai') }}">
            </div>

            <div class="mb-3">
                <label for="selesai">Tahun Selesai</label>
                <input class="border-gray-100 bg-white p-2 w-full rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" type="date" name="selesai" id="selesai" value="{{ old('selesai') }}">
            </div>
            <div class="flex gap-3">
                <a href="{{ route('angkatan.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Kembali</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan</button>

            </div>
        </form>
        <div id="modalDelete" class="fixed inset-0 backdrop-blur-xs bg-opacity-50 items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-3 w-full max-w-sm shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-30 text-red-500 mb-4 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <h2 class="text-lg text-center font-semibold text-gray-800 mb-4">
                    Konfirmasi Hapus
                </h2>
                <p class="text-sm text-center font-semibold text-gray-800 mb-4">
                    Apakah Anda yakin ingin menghapus data siswa ini?
                </p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 rounded cursor-pointer hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    </div>


    </div>
@endsection