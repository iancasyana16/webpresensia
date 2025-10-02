@extends('layouts.dashboard_admin')

@section('title', config('app.name') . ' | Admin')

@section('content')
    <div class="container min-h-screen p-3 bg-gray-100">
        <div class="p-3">
            <div class="p-5 bg-white rounded-lg shadow-md mb-3 flex justify-between items-center">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Input Data Siswa Baru' }}
                </h1>
            </div>

            <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">
                <form action="{{ route('siswa.storeBatch') }}" method="POST">
                    @csrf

                    <!-- Dropdown Angkatan -->
                    <div class="mb-3">
                        <label for="id_angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                        <select name="id_angkatan" id="id_angkatan"
                            class="w-full border-gray-300 rounded p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Angkatan --</option>
                            @foreach ($angkatans as $angkatan)
                                <option value="{{ $angkatan->id }}">{{ $angkatan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Kelas -->
                    <div class="mb-3">
                        <label for="id_kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="id_kelas" id="id_kelas"
                            class="w-full border-gray-300 rounded p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Data Siswa -->
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 mb-3">Data Siswa</h5>
                        <div id="siswa-container" class="space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 siswa-item items-center">
                                <input type="text" name="siswas[0][nama]" placeholder="Nama"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                                    required>

                                <select name="siswas[0][gender]"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                                    required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>

                                <!-- Tombol Hapus -->
                                <button type="button" onclick="removeRow(this)"
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs w-8 h-8 flex items-center justify-center">
                                    X
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-3 mt-4">
                        <button type="button" onclick="addRow()"
                            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                            Tambah Baris
                        </button>

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let index = 1;

        function addRow() {
            let container = document.getElementById('siswa-container');
            let html = `
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 siswa-item items-center">
                <input type="text" name="siswas[${index}][nama]" placeholder="Nama"
                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    required>

                <select name="siswas[${index}][gender]"
                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>

                <button type="button" onclick="removeRow(this)"
                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs w-8 h-8 flex items-center justify-center">
                    X
                </button>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            index++;
        }

        function removeRow(button) {
            button.parentElement.remove();
        }
    </script>
@endsection