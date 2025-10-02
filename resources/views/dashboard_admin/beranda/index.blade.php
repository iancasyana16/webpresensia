@extends('layouts.dashboard_admin')
@section('title', config('app.name') . ' | Admin')
@section('content')
    <div class="container p-3 min-h-screen bg-gray-100">
        <div class="p-3">
            <div class="p-5 bg-white rounded-lg shadow-md mb-3 items-center flex justify-between">
                <h1 class="text-2xl font-bold">
                    {{ $title ?? 'Dashboard' }}
                </h1>
            </div>
            <div class="mb-3 bg-white shadow-md rounded-lg p-3">
                <h2 class="text-xl font-semibold mb-4">Selamat Datang !</h2>
                <p class="text-gray-700">
                    <span class="font-bold">
                        {{Auth::user()->admin()->first()->nama}}
                    </span>
                    Anda telah berhasil masuk
                    ke dashboard. Di sini Anda dapat
                    mengelola berbagai aspek dari aplikasi Anda, termasuk pengguna, konten, dan pengaturan lainnya. Gunakan
                    menu
                    navigasi di sebelah kiri untuk mengakses fitur-fitur yang tersedia.
                </p>
            </div>
            <div class="mb-3 row grid grid-cols-4 gap-2">
                <div class="bg-white flex justify-start gap-3 rounded shadow items-center p-3">
                    <div class="bg-red-200 p-3 rounded font-bold shadow">
                        {{ $jumlahSiswa }}
                    </div>
                    <div class="bg-red-200 p-3 rounded font-semibold shadow w-full">
                        jumlah Siswa
                    </div>
                </div>
                <div class="bg-white flex justify-start gap-3 rounded shadow items-center p-3">
                    <div class="bg-red-200 p-3 rounded font-bold shadow">
                        {{ $jumlahGuru }}
                    </div>
                    <div class="bg-red-200 p-3 rounded font-semibold shadow w-full">
                        jumlah Guru
                    </div>
                </div>
                <div class="bg-white flex justify-start gap-3 rounded shadow items-center p-3">
                    <div class="bg-red-200 p-3 rounded font-bold shadow">
                        {{ $jumlahKelas }}
                    </div>
                    <div class="bg-red-200 p-3 rounded font-semibold shadow w-full">
                        jumlah Kelas
                    </div>
                </div>
                <div class="bg-white flex justify-start gap-3 rounded shadow items-center p-3">
                    <div class="bg-red-200 p-3 rounded font-bold shadow">
                        {{ $jumlahIdCard }}
                    </div>
                    <div class="bg-red-200 p-3 rounded font-semibold shadow w-full">
                        jumlah ID Card
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-lg">
                    <div id="monthlyCalendar" class="grid grid-cols-7 gap-2 text-center text-sm text-gray-700">
                        <!-- div kosong kalender -->
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">
                        Informasi Terbaru
                    </h3>
                    <ul class="text-sm list-disc list-inside text-gray-700 space-y-1">
                        <li>
                            Monitoring kehadiran kini real-time!
                        </li>
                        <li>
                            Fitur izin siswa telah ditingkatkan.
                        </li>
                        <li>
                            Pastikan data siswa dan guru sudah lengkap.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const calendarEl = document.getElementById('monthlyCalendar');
            const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth(); // 0-indexed
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Header hari
            days.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'font-bold text-red-800';
                dayHeader.textContent = day;
                calendarEl.appendChild(dayHeader);
            });

            // Kosongkan slot sebelum tanggal 1
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                calendarEl.appendChild(empty);
            }

            // Buat tanggal-tanggal bulan ini
            for (let d = 1; d <= daysInMonth; d++) {
                const dateCell = document.createElement('div');
                const isToday = d === now.getDate();

                dateCell.className = 'p-2 rounded border ' + (isToday ? 'bg-red-700 text-white font-bold' : 'bg-gray-100');
                dateCell.textContent = d;
                calendarEl.appendChild(dateCell);
            }
        });
    </script>
@endsection