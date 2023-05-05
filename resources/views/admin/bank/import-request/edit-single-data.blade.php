<x-app-layout>
    <x-breadcrumbs name="import-request.edit-single" :data="$sample" />
    <h1 class="font-semibold text-lg my-8">Edit Data</h1>

    <x-card-container>
        <form action="{{ route('admin.import-request.update-single', $sample->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <div>
                    <div class="lg:flex gap-x-3 lg:gap-3">
                        <div class="lg:w-1/2">
                            <x-select name="pickup_month" label="Bulan" id="pickup_month" class="form-select w-full"
                                required>
                                @foreach ($months as $month)
                                    <option value="{{ $month }}"
                                        {{ date('m', strtotime($sample->pickup_date)) == $loop->iteration ? 'selected' : '' }}>
                                        {{ $month }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="lg:w-1/2">
                            <x-select name="pickup_year" label="Tahun" id="pickup_year" class="form-select w-full"
                                required>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}"
                                        {{ date('Y', strtotime($sample->pickup_date)) == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    {{-- label --}}
                    <div class="mb-5">
                        <small class="text-xs text-gray-700">Pengambilan
                            Sampel : <span class="font-semibold"
                                id="pickup_date">{{ date('m/Y', strtotime($sample->pickup_date)) }}</span>
                        </small>
                        <input hidden name="pickup_date" :value="{{ date('m/Y', strtotime($sample->pickup_date)) }}">
                    </div>
                </div>

                <x-select id="province_id" label="Provinsi" name="province_id" isFit="" required>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}"
                            {{ $province->id == $sample->province_id ? 'selected' : '' }}>{{ $province->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-select id="regency_id" label="Kota/Kabupaten" name="regency_id" isFit="" required>
                    @foreach ($regencies as $regency)
                        <option value="{{ $regency->id }}"
                            {{ $regency->id == $sample->regency_id ? 'selected' : '' }}>{{ $regency->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-input id="file_code" label="Kode File" name="file_code" type="text" class="mb-3"
                    :value="$sample->file_code" />
            </div>
            <div class="md:grid md:grid-cols-4 gap-x-4">
                <x-input id="place" label="Tempat Pengambilan Sampel" name="place" type="text"
                    :value="$sample->place" required />
                <x-input id="sample_code" label="Kode Sampel" name="sample_code" type="text" :value="$sample->sample_code"
                    required />
                <x-select id="viruses_id" label="Nama Virus" name="viruses_id" isFit="false" required>
                    @foreach ($viruses as $virus)
                        <option value="{{ $virus->id }}" {{ $virus->id == $sample->viruses_id ? 'selected' : '' }}>
                            {{ $virus->name }}</option>
                    @endforeach
                </x-select>
                <x-select id="genotipes_id" label="Genotipe & Subtipe" name="genotipes_id" isFit="false" required>
                    @foreach ($genotipes as $genotipe)
                        <option value="{{ $genotipe->id }}"
                            {{ $genotipe->id == $sample->genotipes_id ? 'selected' : '' }}>
                            {{ $genotipe->genotipe_code }}</option>
                    @endforeach
                </x-select>
            </div>
            <hr>
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input id="gene_name" label="Nama Gen" name="gene_name" type="text" :value="$sample->gene_name" required />
                <div>
                    <x-input id="size_gene" label="Ukuran Gen" name="size_gene" type="text"
                        placeholder="[ukuran] [satuan]" class="mb-2" :value="$sample->size_gene" required />
                    <small class="text-xs text-gray-700 mt-3">Contoh : 1000 bp</small>
                </div>
                <x-textarea id="sequence_data" label="Data Sekuen" name="sequence_data">
                    {{ $sample->sequence_data }}</x-textarea>
            </div>
            <div class="grid grid-cols-3 gap-x-3">
                <x-input id="sequence_data_file" label="File Data Sekuen" name="sequence_data_file" type="file" />
            </div>
    </x-card-container>
    <x-card-container>
        <div class="md:grid md:grid-cols-2 gap-x-4">
            <x-select id="author_id" label="Nama Penulis" name="author_id" isFit="" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}"
                        {{ $sample->citation->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}
                    </option>
                @endforeach
            </x-select>
            <x-select id="title" label="Judul Artikel" name="title" isFit="" required>
                @foreach ($citations as $citation)
                    <option data-author-id="{{ $citation->author_id }}" value="{{ $citation->id }}"
                        {{ $sample->citation_id == $citation->id ? 'selected' : '' }}>{{ $citation->title }}
                    </option>
                @endforeach
            </x-select>
        </div>

        <div class="text-end mt-4">
            <x-button class="px-6">
                <span>Simpan</span>
            </x-button>
        </div>
    </x-card-container>
    @push('js-internal')
        <script>
            $('document').ready(function() {

                // filter title by author
                $('#author_id').on('change', function() {
                    let authorId = $(this).val();
                    // clear all option and replace with matched author
                    $('#title').empty();
                    @foreach ($citations as $citation)
                        if ({{ $citation->author_id }} == authorId) {
                            $('#title').append(
                                `<option value="{{ $citation->id }}">{{ $citation->title }}</option>`);
                        }
                    @endforeach
                });

                let pickupMonth, pickupYear;
                $('#pickup_month').change(function() {
                    // get index of selected option
                    pickupMonth = $(this).prop('selectedIndex') + 1;
                });
                $('#pickup_year').change(function() {
                    pickupYear = $(this).val();
                });

                $('#pickup_month, #pickup_year').change(function() {
                    let date = `${pickupMonth}/${pickupYear}`;
                    // add 00
                    if (pickupMonth < 10) {
                        date = `0${pickupMonth}/${pickupYear}`;
                    }
                    $('#pickup_date').text(date);
                    $('input[name="pickup_date"]').val(date);
                });


                $('#province_id').on('change', function() {
                    let provinceId = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.bank.get-regency') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            province_id: provinceId
                        },
                        success: function(response) {
                            let data = response;
                            let html = '';
                            data.forEach(function(item) {
                                html += `<option value="${item.id}">${item.name}</option>`;
                            });
                            $('#regency_id').html(html);
                        }
                    });
                });

                $('#viruses_id').on('change', function() {
                    let virusId = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.bank.get-genotipe') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            virus_id: virusId
                        },
                        success: function(response) {
                            let data = response;
                            let html = '';
                            data.forEach(function(item) {
                                html +=
                                    `<option value="${item.id}">${item.genotipe_code}</option>`;
                            });
                            $('#genotipes_id').html(html);
                        }
                    });
                })
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>
