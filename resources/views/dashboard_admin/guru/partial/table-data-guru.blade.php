<div class="overflow-x-auto rounded-xl drop-shadow-2xl border-4 border-white">
    <table class="min-w-full divide-y divide-gray-200 rounded-lg">
        <thead class="bg-sky-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white tracking-wider">
                    No
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white tracking-wider">
                    NIP</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white tracking-wider">
                    Nama Guru
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white tracking-wider">
                    Gender
                </th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-white tracking-wider">
                    Opsi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($gurus as $index => $guru)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $gurus->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $guru->nip }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $guru->nama}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $guru->gender }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                        <x-button-edit :href="route('edit-guru', $guru)" />
                        <x-button-delete :action="route('delete-guru', $guru->id)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        Tidak ada data guru.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>