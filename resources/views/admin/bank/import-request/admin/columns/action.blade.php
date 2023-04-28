@if ($data->status != 3)
    <div class="lg:flex gap-x-2">
        <select id="select-{{ $data->id }}" onchange="changeStatus('{{ $data->id }}', this.value)"
            class="block p-2 text-xs text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
            <option value="pending" {{ $data->status == 0 ? 'selected' : '' }}>Pending</option>
            <option value="accepted" {{ $data->status == 1 ? 'selected' : '' }}>Setuju</option>
            <option value="rejected" {{ $data->status == 2 ? 'selected' : '' }}>Tolak</option>
        </select>
    </div>
@elseif($data->status == 3 && $data->removed_by == null)
    <x-link-button route="{{route('admin.import-request.show', $data->id)}}" color="gray">
        Lihat Permintaan Tunggal
    </x-link-button>
@endif
