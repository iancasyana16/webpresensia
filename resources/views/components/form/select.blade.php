@props(['id' => '', 'name' => '', 'options' => [], 'value' => null])

<select id="{{ $id }}" name="{{ $name }}"
    class="mt-2 w-full p-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    <option value="">-- Pilih {{ ucfirst($name) }} --</option>
    {{ $slot }}
</select>