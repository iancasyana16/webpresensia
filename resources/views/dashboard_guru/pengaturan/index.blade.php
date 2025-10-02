@extends('layouts.dashboard_guru')

@section('title', 'Dashboard Pengaturan')

@section('content')

    <!-- <div class="container p-3 bg-gray-100 min-h-screen"> -->

        <div class="container p-5">

            @if (session('success'))
                <div id="successToast"
                    class="fixed top-5 right-5 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded shadow-lg flex items-center gap-2 animate-fade-in-down">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button onclick="document.getElementById('successToast').remove()"
                        class="ml-4 text-green-700 hover:text-red-600 font-bold">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
                    @foreach ($errors->all() as $error)
                        <div>- {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <h2 class="text-2xl font-bold mb-4 bg-white p-3 shadow-2xl rounded-lg">
                Pengaturan
            </h2>

            <div class="container bg-white rounded-xl p-3 shadow-2xl">
                <form action="{{ Route('update-profile-guru') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mt-3">
                        <div class="p-2 font-bold">
                            <label for="nama_guru">Nama guru</label>
                        </div>
                        <div class="flex gap-2 ">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="nama_guru" id="nama_guru" placeholder="Nama guru"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                value="{{ old('nama_guru', $guru->nama) }}">
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="p-2 font-bold">
                            <label for="username">Username</label>
                        </div>
                        <div class="flex gap-2 ">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="username" id="username" placeholder="Username"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                value="{{ old('username', $user->username) }}">
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="p-2 font-bold">
                            Password Baru
                        </div>
                        <div class="flex gap-2 ">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Password Baru"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="p-2 font-bold">
                            Konfirmasi Password
                        </div>
                        <div class="flex gap-2">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                placeholder="Konfirmasi Password"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit"
                            class="p-3 Pengaturan font-semibold bg-blue-500 text-white rounded text-center cursor-pointer hover:bg-blue-600">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>


        </div>

    </div>
@endsection