@props(['href' => null, 'type' => 'button'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge([
            'class' => 'bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded cursor-pointer px-4 py-2 shadow-md'
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge([
            'class' => 'bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded cursor-pointer px-4 py-2 shadow-md'
        ]) }}>
        {{ $slot }}
    </button>
@endif