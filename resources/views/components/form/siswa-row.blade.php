@props(['index'])

<div class="grid grid-cols-2 gap-4 p-3 rounded-md bg-gray-50">
    <div>
        <x-form.label :for="'nama_' . $index">Nama</x-form.label>
        <x-form.input :id="'nama_' . $index" :name="'siswas[' . $index . '][nama]'" />
    </div>

    <div>
        <x-form.label :for="'gender_' . $index">Gender</x-form.label>
        <x-form.select :id="'gender_' . $index" :name="'siswas[' . $index . '][gender]'" :options="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']" />
    </div>
</div>