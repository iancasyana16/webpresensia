@props(['href'])

<button class="bg-amber-400 text-white p-2 rounded hover:bg-amber-500 cursor-pointer">
    <a href="{{ $href }}">
        {{ $slot }}
    </a>
</button>