<x-card-container>

    <div class="overflow-x-auto">
        <table id="tableContent" class="w-full">
            <thead>
                <tr>
                    <th>Kd. Sampel</th>
                    <th>Virus</th>
                    <th>Genotipe & Subtipe</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Provinsi</th>
                    <th>Gen</th>
                    <th>Sitasi</th>
                    <th class="hidden">Data Sekuen</th>
                    <th>File Sequence</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($samples as $sample)
                    <tr>
                        <td>{{ $sample->sample_code }}</td>
                        <td>{{ $sample->virus->name }}</td>
                        <td>{{ $sample->genotipe->genotipe_code }}</td>
                        <td>{{ date('Y', strtotime($sample->pickup_date)) }}</td>
                        <td>{{ $sample->place }}</td>
                        <td>{{ $sample->province->name ?? null }}</td>
                        <td>{{ $sample->gene_name }}</td>
                        <td>{{ $sample->citation->title }}</td>
                        <td class="hidden">{{ $sample->sequence_data }}</td>
                        <td>{{ $sample->sequence_data_file ?? null }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-card-container>
