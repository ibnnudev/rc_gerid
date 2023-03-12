<x-app-layout>
    <x-breadcrumbs name="virus" />
    <h1 class="font-semibold text-xl my-8">Daftar Virus</h1>

    <x-card-container>

        <div class="text-end">
            <x-link-button route="{{ route('admin.virus.create') }}" color="gray">
                Tambah Virus
            </x-link-button>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full" id="virusTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Virus</th>
                        <th>Genotipe & Subtipe</th>
                        <th>Nama Latin</th>
                        <th>Deskripsi</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viruses as $virus)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ $virus->image ? asset($virus->image) : asset('images/noimage.jpg') }}"
                                            alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $virus->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach ($virus->genotipes as $genotipe)
                                    {{ $genotipe->genotipe_code }}
                                @endforeach
                            </td>
                            <td>
                                {{ $virus->latin_name }}
                            </td>
                            <td>
                                {{ $virus->description }}
                            </td>
                            <td>
                                <div class="lg:flex gap-x-2">
                                    <a href="{{ route('admin.virus.show', $virus->id) }}"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-eye fa-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.virus.edit', $virus->id) }}"
                                        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </a>
                                    <label for="modal" data-name="{{ $virus->name }}" data-id="{{ $virus->id }}"
                                        onclick="btnDelete(this)"
                                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            $(document).ready(function() {
                $('#virusTable').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    // fit content for column 2
                    "columnDefs": [{
                        "targets": 1,
                        "width": "15%"
                    }],
                });
            });
        </script>
    @endpush
</x-app-layout>
