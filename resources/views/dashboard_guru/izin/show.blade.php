@extends('layouts.dashboard_guru')

@section('title', 'Detail Izin Siswa')

@section('content')
    <div class="container p-5">
        <h2 class="text-2xl font-bold mb-4 bg-white p-3 shadow-2xl rounded-xl">
            Detail Izin Siswa
        </h2>
        <div class="grid grid-cols-3 gap-4 mb-3 bg-white shadow-md p-3 rounded">
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">NIS</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $izin->siswa->nis }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Nama</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $izin->siswa->nama_siswa }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Jenis Kelamin</label>
                <div class="p-3 bg-red-100 rounded shadow-md">
                    {{ $izin->siswa->gender }}
                </div>
            </div>
        </div>

            
            <div class="bg-white p-6 rounded-lg shadow flex flex-col md:flex-row gap-6">
                <div class="flex-1 space-y-2 text-sm text-gray-800">
                    <h2 class="text-lg font-semibold mb-3 text-gray-700">Informasi Izin</h2>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700">Tanggal</label>
                        <div class="p-3 bg-red-100 rounded shadow-md">
                            {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700">Alasan</label>
                        <div class="p-3 bg-red-100 rounded shadow-md">
                            {{ $izin->alasan }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-700">Status</label>
                        <div class="p-3 bg-red-100 rounded shadow-md">
                            {{ $izin->status }}
                        </div>
                    </div>

                    @if ($izin->status === 'pending')
                        <div class="mt-4 flex gap-2">
                            <form method="POST" action="{{ route('terima-izin', $izin->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                    Setujui
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tolak-izin', $izin->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                @if ($izin->bukti)
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <h2 class="text-lg font-semibold mb-4 text-gray-700">Bukti Izin</h2>
                        <img src="{{ asset('storage/' . $izin->bukti) }}" alt="Bukti Izin"
                            class="rounded border max-w-full max-h-96 object-contain">
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('dashboard-guru-izin') }}" class="text-blue-600 hover:underline text-sm">
                    ← Kembali ke daftar izin
                </a>
            </div>


    </div>
@endsection