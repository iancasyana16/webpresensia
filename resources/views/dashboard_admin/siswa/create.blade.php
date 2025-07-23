@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')
    <div class="container min-h-screen scroll p-3 bg-gray-100">
        <div class="p-3">
            <div class="p-5 bg-white rounded-lg shadow-md mb-3 items-center flex justify-between">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>
            <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">
                <form action="{{ route('store-siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="idCard" class="block text-md font-bold">
                            ID Card
                        </label>
                        <select name="idCard" id="idCard"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                            <option value="">
                                Pilih ID Card
                            </option>
                            @foreach ($idCards as $card)
                                <option value="{{ $card->id }}" {{ old('id_card') == $card->id ? 'selected' : '' }}>
                                    {{ $card->uid }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nis" class="block text-md font-bold">
                            NIS
                        </label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis') }}"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                        @error('nis')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali NIS Siswa' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="block text-md font-bold">
                            Nama Siswa
                        </label>
                        <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa') }}"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_siswa')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Nama Siswa' }}
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
                            <option value="Laki-laki">
                                Laki-laki
                            </option>
                            <option value="Perempuan">
                                Perempuan
                            </option>
                        </select>
                        @error('gender')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Gender Siswa' }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kelas" class="block text-md font-bold">
                            Kelas
                        </label>
                        <select name="kelas" id="kelas"
                            class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                            <option value="">
                                Pilih Kelas
                            </option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}" {{ old('id_kelas') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas')
                            <div class="text-red-500 m-1">
                                {{ $message = 'Periksa Kembali Kelas Siswa' }}
                                <!-- {{ $message = 'Atur Kelas' }} -->
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" onclick="window.location='{{ route('dashboard-admin-siswa') }}'"
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