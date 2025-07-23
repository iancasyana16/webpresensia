@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')
    <div class="container min-h-screen p-3 bg-gray-100">
        <div class="p-3">
            <div class="p-5 bg-white rounded-lg shadow-md mb-3 items-center flex justify-between">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>
            <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">
                <form action="{{ route('store-guru') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_guru" class="block text-md font-bold">
                            Nama Guru
                        </label>
                        <input type="text" name="nama_guru" id="nama_guru" value="{{ old('nama_guru') }}"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_guru')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Nama Guru' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="block text-md font-bold">
                            NIP
                        </label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                        @error('nip')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali NIP Guru' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="block text-md font-bold">
                            Gender
                        </label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                            <option value="">
                                Pilih Gender
                            </option>
                            <option value="Laki-laki" {{ old('gender', $guru->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('gender', $guru->gender) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('gender')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Gender Guru' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="mapel" class="block text-md font-bold">
                            Mata Pelajaran
                        </label>
                        <select name="mapel" id="mapel"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                            <option value="">
                                Pilih Mata Pelajaran
                            </option>
                            <option value="Matematika" {{ old('mapel', $guru->mapel) == 'Matematika' ? 'selected' : '' }}>
                                Matematika
                            </option>
                            <option value="Bahasa Indonesia" {{ old('mapel', $guru->mapel) == 'Bahasa Indonesia' ? 'selected' : '' }}>
                                Bahasa Indonesia
                            </option>
                            <option value="Bahasa Inggris" {{ old('mapel', $guru->mapel) == 'Bahasa Inggris' ? 'selected' : '' }}>
                                Bahasa Inggris
                            </option>
                            <option value="IPA" {{ old('mapel', $guru->mapel) == 'IPA' ? 'selected' : '' }}>
                                IPA
                            </option>
                            <option value="IPS" {{ old('mapel', $guru->mapel) == 'IPS' ? 'selected' : '' }}>
                                IPS
                            </option>
                            <option value="PAI" {{ old('mapel', $guru->mapel) == 'PAI' ? 'selected' : '' }}>
                                PAI
                            </option>
                        </select>
                        @error('mapel')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Mapel Guru' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" onclick="location.href='{{ route('dashboard-admin-guru') }}'"
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