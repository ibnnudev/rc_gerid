<div class="lg:flex gap-x-2">
    @if ($data->status == 1)
        <x-link-button color="gray" onclick="btnImport('{{ $data->id }}', '{{ $data->filename }}')">
            <i class="fas fa-file-import fa-sm mr-2"></i> Import
        </x-link-button>
    @endif
    <a href="{{ route('admin.import-request.edit', $data->id) }}"
        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-edit fa-sm"></i>
    </a>
    @if ($data->status !== 1)
        <label for="modal" onclick="btnDelete('{{ $data->id }}', '{{ $data->filename }}')"
            class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
            <i class="fas fa-trash fa-sm"></i>
        </label>
    @endif
</div>
