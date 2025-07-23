@extends('layouts.dashboard_guru')

@section('title', 'Absen Manual')

@section('content')
    <div class="container p-5">
        <div class="bg-white shadow-md mb-3 rounded">
            <h2 class="text-xl font-bold p-3">Form Absen Manual</h2>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-3 bg-white shadow-md p-3 rounded">
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">NIS</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $siswa->nis }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Nama</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $siswa->nama_siswa }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Jenis Kelamin</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $siswa->gender }}
                </div>
            </div>
        </div>
        <div class=" bg-gray-50 shadow-md rounded-lg p-6">
            <form action="{{ route('store-absen') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                <input type="hidden" name="id_guru" value="{{ $guruId }}">
                <input type="hidden" name="id_perekam" value="{{ $perekamId }}">
                <input type="hidden" name="tipe_kehadiran" value="masuk">
                <input type="hidden" name="waktu_tap" value="{{ now()->format('Y-m-d H:i:s') }}">

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium">Status Kehadiran</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-10 shadow-md focus:border-blue-500 focus:ring-blue-500">
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="5"
                        class="mt-1 block w-full border border-gray-100 bg-white p-2 rounded-md h-30 shadow-md focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('dashboard-guru-absen') }}"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-semibold">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection