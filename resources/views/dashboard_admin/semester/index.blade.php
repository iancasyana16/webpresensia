@extends('layouts.dashboard_admin')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Daftar Semester</h2>

        <a href="{{ route('semester.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tambah Semester</a>

        <table class="w-full mt-4 border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Tahun</th>
                    <th class="px-4 py-2">Periode</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semesters as $s)
                    <tr>
                        <td class="border px-4 py-2">{{ $s->nama }}</td>
                        <td class="border px-4 py-2">{{ $s->tahun }}</td>
                        <td class="border px-4 py-2">{{ $s->mulai }} s/d {{ $s->selesai }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('semester.create', $s->id) }}"
                                class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>
                            <form action="{{ route('semester.create', $s->id) }}" method="POST" class="inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded"
                                    onclick="return confirm('Hapus semester ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection