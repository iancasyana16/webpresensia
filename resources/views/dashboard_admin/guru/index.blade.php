@extends('layouts.dashboard_admin')

@section('title', config('app.name') . ' | Admin')

@section('content')
    <div class="container min-h-screen p-3 bg-gray-100">
        <div class="p-3">

            <x-modal.toast />

            <div class="p-5 bg-white rounded-lg shadow-md mb-3 flex items-center justify-between">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>

            <div class="flex justify-between items-center mb-3">
                <x-button-add href="{{ route('create-guru') }}">
                    Input Guru Baru
                </x-button-add>

                <x-search-bar name="search" placeholder="Cari guru..." :value="request('search')"
                    onkeydown="if(event.key === 'Enter') handleSearchChange()" />
            </div>

            @include('dashboard_admin.guru.partial.table-data-guru')

            <div class="mt-3">
                {{ $gurus->links('components.pagination') }}
            </div>

            <x-modal-delete />
        </div>
    </div>
@endsection