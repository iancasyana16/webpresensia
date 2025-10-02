@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">📋 Daftar Siswa</h2>

        <a href="{{ route('siswa.createBatch') }}" class="btn btn-primary mb-3">➕ Tambah Batch Siswa</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>ID Card</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $siswa->angkatan->tahun ?? '-' }}</td>
                        <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $siswa->idCard->nomor ?? '-' }}</td>
                        <td>{{ $siswa->user->username ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection