@extends('layouts.app')
<div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
    <x-table.body>
        <x-slot:head>
            <x-table.th>No</x-table.th>
            <x-table.th>NIS</x-table.th>
            <x-table.th>Nama Siswa</x-table.th>
        </x-slot:head>

        <x-slot:body>
            <x-table.tr>
                <x-table.td>1</x-table.td>
                <x-table.td>2203037</x-table.td>
                <x-table.td>Casyana</x-table.td>
            </x-table.tr>
        </x-slot:body>
    </x-table.body>
</div>