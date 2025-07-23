<nav class="container-fluid bg-red-800 sticky top-0 z-50 shadow-md print:hidden">
    <div class="container mx-auto px-4">
        <div class="flex justify-start items-center h-16">
            <div class="flex">
                <img src="{{ asset('assets/Presensia.png') }}" alt="Logo" width="150">
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                <a href="{{ route('dashboard-guru-absen') }}"
                    class="text-white hover:bg-red-900 rounded-md p-3 font-bold {{ request()->routeIs('dashboard-guru-absen') ? 'bg-red-900' : 'hover:bg-red-900' }}">
                    Absen
                </a>
                <a href="{{ route('dashboard-guru-izin') }}"
                    class="text-white hover:bg-red-900 rounded-md p-3 font-bold {{ request()->routeIs('dashboard-guru-izin') ? 'bg-red-900' : 'hover:bg-red-900' }}">
                    Izin
                </a>
                <a href="{{ route('dashboard-guru-laporan') }}"
                    class="text-white hover:bg-red-900 rounded-md p-3 font-bold {{ request()->routeIs('dashboard-guru-laporan') ? 'bg-red-900' : 'hover:bg-red-900' }}">
                    Laporan
                </a>
                <a href="{{ route('dashboard-guru-pengaturan') }}"
                    class="text-white hover:bg-red-900 rounded-md p-3 font-bold {{ request()->routeIs('dashboard-guru-pengaturan') ? 'bg-red-900' : 'hover:bg-red-900' }}">
                    Pengaturan
                </a>
                <a href="#" class="text-white hover:bg-red-900 rounded-md p-3 font-bold">
                    <button type="button" class="cursor-pointer" onclick="openLogoutModal()">Logout</button>
                </a>
            </div>
        </div>
    </div>
</nav>

<div id="modalLogout" class="fixed inset-0 backdrop-blur-sm bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-30 text-red-500 mb-4 mx-auto">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
        </svg>
        <h2 class="text-xl font-bold text-center mb-4 text-gray-800">Konfirmasi Logout</h2>
        <p class="text-gray-700 text-center mb-6">Apakah Anda yakin ingin keluar dari sesi ini?</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </button>
            <form id="logoutForm" action="{{ Route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        document.getElementById('modalLogout').classList.remove('hidden');
        document.getElementById('modalLogout').classList.add('flex');
    }

    function closeLogoutModal() {
        document.getElementById('modalLogout').classList.add('hidden');
        document.getElementById('modalLogout').classList.remove('flex');
    }
</script>