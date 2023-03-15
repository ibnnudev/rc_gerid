<a href="{{ route('admin.transmission.edit', $transmission->id) }}"
    class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
    <i class="fas fa-edit fa-sm"></i>
</a>
<label for="modal" onclick="btnDelete('{{ $transmission->id }}', '{{ $transmission->name }}')"
    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
    <i class="fas fa-trash fa-sm"></i>
</label>
