<x-guest-layout>
    @push('css-internal')
        <!-- Datatable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.jqueryui.min.css">
    @endpush
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
            Daftar Sitasi
        </div>
        <div class="h-[30em] overflow-y-scroll" style="scrollbar-width: thin">
            <form action="{{ route('downloadFasta') }}" method="get">
                <div class="dt-responsive table-responsive">
                    <table id="citationTable" class="table w-fit">
                        <thead class="hidden">
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCitations as $item)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="id_fasta" name="fasta[]"
                                            value="{{ $item['id_citation'] }}" class="id_fasta">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div>
                                            <div>{{ $item['user'] }}</div>
                                            <div><a href="{{ route('detailCitation', $item['id_citation']) }}"
                                                    class="text-blue-500">{{ $item['title'] }}</a></div>
                                            <div>{{ $item['province'] . ',' . $item['regency'] }}</div>
                                            <div class="text-sm">
                                                @if (isset($item['author']))
                                                    {{ $item['author']['name'] . ',' . $item['author']['member'] }}
                                                @endif
                                            </div>
                                            <div class="text-sm">
                                                <p>{{ $item['monthYear'] }}</p>
                                                <p>NCBI:{{ $item['accession_ncbi'] }} | INDAGI:
                                                    {{ $item['accession_indagi'] }}
                                                </p>
                                            </div>
                                            <p><a href="{{ route('detailFasta', $item['id_citation']) }}"
                                                    class="text-blue-500">Fasta</a></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="p-6">
            <button class="download" id="download" type="submit" class="hover:text-blue-800">Download
                selected</button>
        </div>
    </div>
    @push('js-internal')
        <!-- Datatable -->
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.jqueryui.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#citationTable').DataTable({
                    processing: true,
                    "drawCallback": function(settings) {
                        $('#citationTable thead').remove()
                        // $('#citationTable_filter').remove()
                        $('#citationTable_length').remove()
                    },
                });
            });

            $('#download').click(function() {
                var checked = [];
                $("input:checkbox[id=id_fasta]:checked").each(function() {
                    checked.push($(this).val());
                });
                if (checked.length == 0) {
                    alert('Please select at least one fasta');
                    return false;
                }
            });
        </script>
    @endpush
</x-guest-layout>
