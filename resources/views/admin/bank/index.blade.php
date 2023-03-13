<x-app-layout>
    <x-breadcrumbs name="bank" />
    <h1 class="font-semibold text-xl my-8">Bank Data</h1>

    <x-card-container>
        <div class="text-end mb-4">
            <x-link-button route="{{ route('admin.bank.create') }}" color="gray">
                Tambah Bank Data
            </x-link-button>
        </div>

        <table id="samplesTable" class="w-full">
            <thead>
                <tr>
                    <th>Kd. Sampel</th>
                    <th>Virus</th>
                    <th>Genotipe & Subtipe</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Gen</th>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($samples as $sample)
                    <tr>
                        <td>{{ $sample->sample_code }}</td>
                        <td>{{ $sample->virus->name }}</td>
                        <td>{{ $sample->genotipe->genotipe_code }}</td>
                        <td>{{ date('M, Y', strtotime($sample->pickup_date)) }}</td>
                        <td>{{ $sample->place }}</td>
                        <td>{{ $sample->gene_name }}</td>
                        <td>
                            @foreach ($sample->citations as $citation)
                                {{ $citation->title }}
                            @endforeach
                        </td>
                        <td>{{$sample->author->name}}</td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card-container>
    @push('js-internal')
        <script>
            $(function() {
                $('#samplesTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    // fit content all column
                    columnDefs: [{
                        targets: 'no-sort',
                        orderable: false,
                    }],
                });
            });
        </script>
    @endpush
</x-app-layout>
