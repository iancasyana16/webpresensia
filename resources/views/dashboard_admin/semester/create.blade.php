@extends('layouts.dashboard_admin')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Semester</h2>

        <form action="{{ route('semester.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Semester</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="number" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="mulai" name="mulai" value="{{ old('mulai') }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" id="selesai" name="selesai" value="{{ old('selesai') }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('semester.create') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection