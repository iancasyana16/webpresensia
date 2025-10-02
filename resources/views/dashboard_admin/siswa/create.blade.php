@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')

    <div class="container min-h-screen scroll p-3 bg-gray-100">

        <div class="p-3">

            <x-title>
                Tambah Data Siswa Baru
            </x-title>

            <div class="bg-gray-50 drop-shadow-2xl rounded-lg p-5">

                <form action="{{ route('store-siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <div class="mb-3">
                            <x-form.label for="angkatan">Angkatan</x-form.label>
                            <x-form.select id="angkatan" name="angkatan">
                                @foreach ($angkatans as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div class="mb-3">
                            <x-form.label for="kelas">Kelas</x-form.label>
                            <x-form.select id="kelas" name="kelas">
                                @foreach ($kelas as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div class="mb-3">
                            <div id="siswa-container">
                                <x-form.siswa-row :index="0" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="addRow()" class="px-3 py-2 bg-green-500 text-white rounded-md">Tambah Siswa</button>
                        <x-button.add type="submit">Simpan</x-button.add>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let siswaIndex = 1;
        function addRow() {
            let container = document.getElementById('siswa-container');
            let newRow = `
            @php ob_start(); @endphp
            <x-form.siswa-row :index="'__INDEX__'" />
            @php $template = ob_get_clean(); @endphp
            {!! str_replace('__INDEX__', "'+siswaIndex+'", $template) !!}
        `;
            container.insertAdjacentHTML('beforeend', newRow);
            siswaIndex++;
        }
    </script>
@endsection