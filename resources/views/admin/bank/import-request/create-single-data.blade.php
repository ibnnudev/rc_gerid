<x-app-layout>
    <x-breadcrumbs name="import-request.create-single" :data="$fileCode" />
    <h1 class="font-semibold text-lg my-8">Tambah Data</h1>

    <x-card-container>
        <form action="{{ route('admin.import-request.store-single') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <div>
                    <div class="lg:flex gap-x-3 lg:gap-3">
                        <div class="lg:w-1/2">
                            <x-select name="pickup_month" label="Bulan" id="pickup_month" class="form-select w-full"
                                required>
                                @foreach ($months as $month)
                                    <option value="{{ $month }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $month }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="lg:w-1/2">
                            <x-select name="pickup_year" label="Tahun" id="pickup_year" class="form-select w-full"
                                required>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    {{-- label --}}
                    <div class="mb-5">
                        <small class="text-xs text-gray-700">Pengambilan
                            Sampel : <span class="font-semibold" id="pickup_date"></span>
                        </small>
                        <input type="hidden" name="pickup_date">
                    </div>
                </div>

                <x-select id="province_id" label="Provinsi" name="province_id" isFit="" required>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $province->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-select id="regency_id" label="Kota/Kabupaten" name="regency_id" isFit="" required>
                </x-select>
                <x-input id="file_code" label="Kode File" name="file_code" type="text" class="mb-3"
                    :value="$fileCode" readonly />
            </div>
            <div class="md:grid md:grid-cols-4 gap-x-4">
                <x-input id="place" label="Tempat Pengambilan Sampel" name="place" type="text" required />
                <x-input id="sample_code" label="Kode Sampel" name="sample_code" type="text" required />
                <x-select id="viruses_id" label="Nama Virus" name="viruses_id" isFit="false" required>
                    @foreach ($viruses as $virus)
                        <option value="{{ $virus->id }}">{{ $virus->name }}</option>
                    @endforeach
                </x-select>
                <x-select id="genotipes_id" label="Genotipe & Subtipe" name="genotipes_id" isFit="false" required>
                </x-select>
            </div>
            <hr>
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input id="gene_name" label="Nama Gen" name="gene_name" type="text" required />
                <div>
                    <x-input id="size_gene" label="Ukuran Gen" name="size_gene" type="text"
                        placeholder="[ukuran] [satuan]" class="mb-2" required />
                    <small class="text-xs text-gray-700 mt-3">Contoh : 1000 bp</small>
                </div>
                <x-textarea id="sequence_data" label="Data Sekuen" name="sequence_data"></x-textarea>
            </div>
            <div class="grid grid-cols-3 gap-x-3">
                <x-input id="sequence_data_file" label="File Data Sekuen" name="sequence_data_file" type="file" />
            </div>
    </x-card-container>
    <x-card-container>
        <div class="md:grid md:grid-cols-2 gap-x-4">
            <x-select id="author_id" label="Nama Penulis" name="author_id" isFit="" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $author->name }}
                    </option>
                @endforeach
            </x-select>
            <x-select id="title" label="Judul Artikel" name="title" isFit="" required>
                @foreach ($citations as $citation)
                    <option data-author-id="{{ $citation->author_id }}" value="{{ $citation->id }}"
                        {{ $loop->first ? 'selected' : '' }}>{{ $citation->title }}
                    </option>
                @endforeach
            </x-select>
            <input type="hidden" name="citation_id">
        </div>

        {{-- alert --}}
        <div class="alert shadow-sm mt-4">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current flex-shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                    <strong>Info!</strong> Jika judul artikel tidak ada, silahkan tambah terlebih dahulu.
                </span>
            </div>
        </div>

        <div class="md:grid md:grid-cols-3 gap-x-4 mt-4">
            <x-input id="new_title" label="Judul Artikel Baru" name="new_title" type="text" />
            <x-input id="new_author" label="Penulis Baru" name="new_author" type="text" />
            <x-input id="new_member" label="Anggota Baru" name="new_member" type="text" />
        </div>

        <div class="text-end mt-4">
            <x-button class="px-6">
                <span>Tambah</span>
            </x-button>
        </div>
    </x-card-container>
    </form>
    @push('js-internal')
        <script>
            $('document').ready(function() {
                // filter title by author
                $('#author_id').on('change', function() {
                    let authorId = $(this).val();
                    // clear all option and replace with matched author
                    $('#title').empty();
                    @foreach ($citations as $citation)
                        @if ($citation->author_id == $author->id)
                            $('#title').append(
                                `<option value="{{ $citation->id }}">{{ $citation->title }}</option>`);
                        @endif
                    @endforeach
                });

                // set citation_id value by first option in title select
                let citation_id = $('#title').val();
                $('input[name="citation_id"]').val(citation_id);


                let pickupMonth, pickupYear;
                // get current month and year
                let date = new Date();
                pickupMonth = date.getMonth() + 1 < 10 ? `0${date.getMonth() + 1}` : date.getMonth() + 1;
                pickupYear = date.getFullYear();

                // set selected month and year
                $('#pickup_month').prop('selectedIndex', pickupMonth - 1);
                $('#pickup_year').val(pickupYear);

                // set pickup date
                $('#pickup_date').text(`${pickupMonth}/${pickupYear}`);
                $('input[name="pickup_date"]').val(`${pickupMonth}/${pickupYear}`);

                $('#pickup_month').change(function() {
                    pickupMonth = $(this).prop('selectedIndex') + 1;
                });
                $('#pickup_year').change(function() {
                    pickupYear = $(this).val();
                });

                $('#pickup_month, #pickup_year').change(function() {
                    if (pickupYear == undefined) {
                        let date = new Date();
                        pickupYear = date.getFullYear();
                    }

                    let date = `${pickupMonth}/${pickupYear}`;
                    // add 00
                    if (pickupMonth < 10) {
                        date = `0${pickupMonth}/${pickupYear}`;
                    }

                    $('#pickup_date').text(date);
                    $('input[name="pickup_date"]').val(date);
                });

                $('#author').on('change', function() {
                    let authorId = $(this).val();
                    let citation_id = $('#title').val();
                    $('input[name="citation_id"]').val(citation_id);
                })


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
