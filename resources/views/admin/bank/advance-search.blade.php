<x-app-layout>
    <x-breadcrumbs name="bank.advanced-search" />
    <h1 class="font-semibold text-lg my-8">Pencarian Data Sample</h1>

    <x-card-container>
        <div class="xl:grid grid-cols-3 gap-x-3">
            <x-select id="sample_code" name="sample_code" label="Kode Sample">
                @forelse ($attributes['sampleCodes'] as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
            <x-select id="virus_id" name="virus_id" label="Virus">
                @forelse ($attributes['viruses'] as $item => $key)
                    <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
            <x-select id="gene_name" name="gene_name" label="Nama Gen">
                @forelse ($attributes['geneNames'] as $item => $key)
                    <option value="{{ $key }}">{{ $key }}</option>
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
            <x-select id="genotipe_id" name="genotipe_id" label="Genotipe">
                @forelse ($attributes['genotipes'] as $item => $key)
                    <option value="{{ $key['id'] }}">{{ $key['genotipe_code'] }}</option>
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
            <x-select id="province_id" name="province_id" label="Provinsi">
                @forelse ($attributes['provinces'] as $item => $key)
                    @if ($key != null)
                        <option value="{{ $key['id'] }}">{{ $key['name'] }}</option>
                    @endif
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
            <x-select id="pickup_date" name="pickup_date" label="Tahun Pengambilan">
                @forelse ($attributes['years'] as $item => $key)
                    @if ($key != null)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endif
                @empty
                    <option value="">Tidak ada data</option>
                @endforelse
            </x-select>
        </div>

        <div class="flex gap-x-2 justify-end">
            <x-link-button id="reset" color="gray">
                Batal
            </x-link-button>
            <x-button color="primary" type="button" id="search">
                Jalankan Pencarian
            </x-button>
        </div>
    </x-card-container>

    <div id="result"></div>

    @push('js-internal')
        <script>
            $(function() {
                // attributes variable
                let provinceId, virusId, genotipeId, geneName, sampleCode, pickupDate;

                $('#sample_code').on('change', function() {
                    sampleCode = $(this).val();
                });

                $('#virus_id').on('change', function() {
                    virusId = $(this).val();
                });

                $('#gene_name').on('change', function() {
                    geneName = $(this).val();
                });

                $('#genotipe_id').on('change', function() {
                    genotipeId = $(this).val();
                });

                $('#province_id').on('change', function() {
                    provinceId = $(this).val();
                });

                $('#pickup_date').on('change', function() {
                    pickupDate = $(this).val();
                });

                $('#reset').on('click', function() {
                    $('#sample_code').val('');
                    $('#virus_id').val('');
                    $('#gene_name').val('');
                    $('#genotipe_id').val('');
                    $('#province_id').val('');
                    $('#pickup_date').val('');

                    sampleCode = '';
                    virusId = '';
                    geneName = '';
                    genotipeId = '';
                    provinceId = '';
                    pickupDate = '';

                    $('#result').html('');
                })

                $('#search').on('click', function(e) {
                    e.preventDefault();
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('admin.bank.get-data') }}',
                        data: {
                            province_id: provinceId,
                            virus_id: virusId,
                            genotipe_id: genotipeId,
                            gene_name: geneName,
                            sample_code: sampleCode,
                            pickup_date: pickupDate,
                        },
                        success: function(response) {
                            if (response != null) {
                                $('#result').html(response);
                                $('#tableContent').DataTable({
                                    responsive: true,
                                    autoWidth: true,
                                    columnDefs: [{
                                        orderable: false,
                                        targets: [8]
                                    }],
                                    dom: 'Bfrtip',
                                    buttons: [{
                                        extend: 'csv',
                                        filename: 'Data Sample',
                                        bom: true
                                    }, {
                                        extend: 'excel',
                                        filename: 'Data Sample',
                                        bom: true
                                    }, {
                                        extend: 'print',
                                        filename: 'Data Sample',
                                        customize: function(win) {
                                            $(win.document.body)
                                                .css('font-size', '10pt')
                                                .prepend(
                                                    '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                                                );

                                            $(win.document.body).find('table')
                                                .addClass('compact')
                                                .css('font-size', 'inherit');
                                        }
                                    }],
                                });
                            }
                        },
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
