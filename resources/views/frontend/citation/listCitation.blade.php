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
        <!-- Cari Sitasi -->
        <form action="{{ route('listCitation') }}" method="POST" class="px-6 py-8">
            @csrf
            <input type="hidden" name="virus_id" value="{{ $virus->id }}" />
            <div class="grid lg:grid-cols-5 gap-4 items-center">
                <div>
                    <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tahun
                    </label>
                    <select id="year" name="year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected value="">Pilih tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Provinsi
                    </label>
                    <select id="province" name="province"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected value="">Pilih provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Penulis
                    </label>
                    <select id="author" name="author"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected value="">Pilih penulis</option>
                        @foreach ($authors as $key => $val)
                            <option value="{{ $val['author']['id'] }}">{{ $val['author']['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="genotipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Genotipe
                    </label>
                    <select id="genotipe" name="genotipe"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected value="">Pilih genotipe</option>
                        @foreach ($virus->genotipes as $genotipe)
                            <option value="{{ $genotipe->id }}">{{ $genotipe->genotipe_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="text-white mt-7 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-normal rounded-lg text-sm px-9 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Cari
                        Sitasi</button>
                </div>
            </div>
        </form>
        <div class="h-[30em] overflow-y-scroll" style="scrollbar-width: thin">
            <form action="{{ route('downloadFasta') }}" method="get">
                <div class="dt-responsive table-responsive">
                    <table id="citationTable" class="table w-fit">
                        <thead class="hidden">
                            <tr>
                                {{-- <th></th> --}}
                                <th>No</th>
                                <th>Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCitations as $item)
                                <tr>
                                    {{-- <td>
                                        <input class="form-check-input" type="checkbox" id="id_fasta" name="fasta[]"
                                            value="{{ $item['id_citation'] }}" class="id_fasta">
                                    </td> --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div>
                                            <div>{{ $item['user'] }}</div>
                                            <div><a href="{{ route('detailCitation', $item['id_citation']) }}"
                                                    class="text-blue-500">{{ $item['citation'] }}</a></div>
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
        {{-- <div class="p-6">
            <button class="download" id="download" type="submit" class="hover:text-blue-800">Download
                selected</button>
        </div> --}}
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
                    responsive: true,
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

            // check if there's request and select the option
            var year = "{{ $request->year }}";
            var province = "{{ $request->province }}";
            var author = "{{ $request->author }}";
            var genotipe = "{{ $request->genotipe }}";
            if (year != '') {
                $('#year').val(year);
            }

            if (province != '') {
                $('#province').val(province);
            }

            if (author != '') {
                $('#author').val(author);
            }

            if (genotipe != '') {
                $('#genotipe').val(genotipe);
            }
        </script>
    @endpush
</x-guest-layout>
