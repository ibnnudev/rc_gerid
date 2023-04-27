<div class="lg:flex gap-x-2">
    @if (auth()->user()->role == 'admin')
        <div class="lg:flex gap-x-2">
            <select id="select-{{ $sample->id }}" onchange="changeStatus('{{ $sample->id }}', this.value)"
                class="block p-2 text-xs text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                <option value="2" {{ $sample->is_active == 2 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $sample->is_active == 1 ? 'selected' : '' }}>Setuju</option>
                <option value="3" {{ $sample->is_active == 3 ? 'selected' : '' }}>Tolak</option>
            </select>
        </div>
    @else
        <a href="{{ route('admin.import-request.show-single', $sample->id) }}"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
            <i class="fas fa-eye fa-sm"></i>
        </a>
        <a href="{{ route('admin.import-request.edit-single', $sample->id) }}"
            class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
            <i class="fas fa-edit fa-sm"></i>
        </a>
    @endif
    {{-- <label for="modal" onclick="btnDelete('{{ $sample->id }}', '{{ $sample->sample_code }}')"
        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-trash fa-sm"></i>
    </label> --}}
</div>
