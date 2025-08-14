<div id="deleteModal" class="fixed inset-0 backdrop-blur-xs bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-3 w-full max-w-sm shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-30 text-red-500 mb-4 mx-auto">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
        </svg>
        <h2 class="text-lg text-center font-bold mb-4">Konfirmasi Hapus</h2>
        <p class="text-center mb-3" id="deleteMessage">Apakah Anda yakin ingin menghapus data ini?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded cursor-pointer hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, message) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteMessage').textContent = message;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>