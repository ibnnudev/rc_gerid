<x-app-layout>
    <x-breadcrumbs name="bank.edit" :data="$sample" />
    <h1 class="font-semibold text-lg my-8">Edit Data</h1>

    <x-card-container>
        <form action="{{ route('admin.bank.update', $sample->id) }}" method="POST">
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
                            Sampel : <span class="font-semibold" id="pickup_date">
                                {{ date('m/Y', strtotime($sample->pickup_date)) }}
                            </span>
                        </small>
                        <input type="hidden" name="pickup_date"
                            value="{{ date('m/Y', strtotime($sample->pickup_date)) }}">
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
                <x-input id="place" label="Tempat Pengambilan Sampel" name="place" :value="$sample->place"
                    type="text" required />
                <x-input id="title" label="Judul Artikel" name="title" :value="$sample->citations->title" type="text"
                    required />
                <x-select id="authors_id" label="Nama Penulis" name="authors_id" isFit="" required>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ $author->id == $sample->authors_id ? 'selected' : '' }}>
                            {{ $author->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <hr>
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input id="sample_code" label="Kode Sampel" name="sample_code" :value="$sample->sample_code" type="text"
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
                <x-input id="gene_name" label="Nama Gen" name="gene_name" :value="$sample->gene_name" type="text" required />
                <div class="col-span-2 ">
                    <x-textarea id="sequence_data" label="Data Sekuen" name="sequence_data" required>
                        {{ $sample->sequence_data }}</x-textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <x-button class="px-6">
                    <span>Tambah</span>
                </x-button>
            </div>

        </form>
    </x-card-container>
    @push('js-internal')
        <script>
            $('document').ready(function() {
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
