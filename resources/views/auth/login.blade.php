@extends('layouts.login')

@section('title', 'Login')

@section('content')
    <div class="container max-w-xl m-auto">
        <div class="flex gap-1 bg-gray-100 shadow-2xl p-5 rounded-lg">
            <div class="flex-1">
                <div class="bg-white p-8 rounded-lg shadow-md h-full flex flex-col items-center justify-center">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo">
                    <h1 class="text-2xl font-bold text-gray-800 mt-4 text-center">Login Page</h1>
                </div>
            </div>
            <div class="flex-1">
                <div class=" bg-white p-8 rounded-lg shadow-md h-full flex flex-col items-center justify-center">

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 font-xs p-2 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4 flex items-center gap-2">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="username" id="username" placeholder="Username"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 flex items-center gap-2">
                            <div class="bg-gray-200 p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Password"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                required>
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 cursor-pointer transition duration-200">
                            Login
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center text-white">
            &copy; Copyright SDN 1 TUKDANA {{ date('Y') }}
        </div>

    </div>
@endsection