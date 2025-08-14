@props([
    'name' => 'search',
    'placeholder' => 'Pencarian',
    'value' => '',
    'oninput' => null
])

<div class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="w-6 h-6 text-gray-500">
        <path fill-rule="evenodd"
        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5 a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69 a.75.75 0 1 1-1.06 1.06l-4.69-4.69 A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
    </svg>

    <input
    type="search"
    name="{{ $name }}"
    id="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    {{ $attributes }}
    class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 bg-white w-full"
/>

    <script>
        function handleSearchChange() {
                        const query = document.getElementById('search').value;
                        const url = new URL(window.location.href);
                            url.searchParams.set('search', query);
    
                // Gunakan history.pushState agar URL berubah tanpa reload (opsional)
                window.location.href = url.toString();
            }
    </script>
</div>
