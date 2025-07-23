@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')
    <div class="container min-h-screen p-3 bg-gray-100">
        <div class="p-3">
            <div class="p-5 bg-white rounded-lg shadow-md mb-4 items-center flex justify-between">
                <h1 class="text-2xl font-bold">
                {{ $title ?? 'Dashboard' }}
            </h1>
            </div>
            <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">
                <form action="{{ route('update-kelas', $kelas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_kelas" class="block text-md font-bold">
                            Nama Kelas
                        </label>
                        <input type="text" name="nama_kelas" id="nama_kelas" required
                            value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-3">
                        <label for="wali_kelas" class="block text-md font-bold">
                            Wali Kelas
                        </label>
                        <select name="wali_kelas" id="wali_kelas" required
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                            <option value="">
                                Pilih Wali Kelas
                            </option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('wali_kelas', $kelas->id_guru) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" onclick="location.href='{{ route('dashboard-admin-kelas') }}'"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-bold cursor-pointer text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-bold cursor-pointer text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection