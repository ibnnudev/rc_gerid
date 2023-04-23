<div class="lg:flex gap-x-2">
    <select id="select-{{ $data->id }}" onchange="changeStatus('{{ $data->id }}', this.value)"
        class="block p-2 text-xs text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
        <option value="pending" {{ $data->status == 0 ? 'selected' : '' }}>Pending</option>
        <option value="accepted" {{ $data->status == 1 ? 'selected' : '' }}>Setuju</option>
        <option value="rejected" {{ $data->status == 2 ? 'selected' : '' }}>Tolak</option>
    </select>

    {{-- <label for="modal" onclick="btnDelete('{{ $data->id }}', '{{ $data->name }}')"
        class="text-white flex bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-3 text-center inline-flex items-center">
        <i class="fas fa-trash fa-sm"></i>
    </label> --}}
</div>
