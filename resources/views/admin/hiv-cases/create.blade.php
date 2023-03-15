<x-app-layout>
    <x-breadcrumbs name="hiv-cases.create" />
    <h1 class="font-semibold text-lg my-8">Tambah Kasus</h1>

    <x-card-container>
        <form action="{{ route('admin.hiv-case.store') }}" method="POST">
            @csrf
            <div class="xl:grid grid-cols-3 gap-x-3">
                {{-- idkd, idkd address, lat, long --}}
                <x-input autocomplete="off" id="idkd" name="idkd" label="IDKD" type="text" tip="(Nama-Tahun-Tanggal-Bulan)"
                    required />
                <x-input autocomplete="off" id="idkd_address" name="idkd_address" label="Alamat IDKD" type="text" required />
                <div class="grid grid-cols-2 gap-x-3">
                    <x-input autocomplete="off" id="latitude" name="latitude" label="Latitude" type="text" required />
                    <x-input autocomplete="off" id="longitude" name="longitude" label="Longitude" class="max-xs-auto" type="text"
                        required />
                </div>

                {{-- province_id, regency_id, dictrict_id, region --}}
                <x-select id="province_id" label="Provinsi" name="province_id" isFit="" required>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $province->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-select id="regency_id" label="Kota/Kabupaten" name="regency_id" isFit="" required />
                <div class="xl:grid grid-cols-2 gap-x-3">
                    <x-select id="district_id" label="Kecamatan" name="district_id" isFit="" required />
                    <x-select id="region" label="Bagian" name="region" isFit="" required>
                        <option value="Timur">Timur</option>
                        <option value="Barat">Barat</option>
                        <option value="Selatan">Selatan</option>
                        <option value="Utara">Utara</option>
                        <option value="Pusat">Pusat</option>
                    </x-select>
                </div>

                {{-- count_of_cases, age, age_group, sex --}}
                <div class="xl:grid grid-cols-2 gap-x-3">
                    <x-input autocomplete="off" id="count_of_cases" name="count_of_cases" label="Jumlah Kasus" type="number" required />
                    <x-input autocomplete="off" id="age" name="age" label="Usia" type="number" required />
                </div>
                <div class="xl:grid grid-cols-2 gap-x-3">
                    <x-select id="age_group" label="Kelompok Usia" name="age_group" isFit="" required>
                        <option value="0-4">0-4</option>
                        <option value="5-9">5-9</option>
                        <option value="10-14">10-14</option>
                        <option value="15-19">15-19</option>
                        <option value="20-24">20-24</option>
                        <option value="25-29">25-29</option>
                        <option value="30-34">30-34</option>
                        <option value="35-39">35-39</option>
                        <option value="40-44">40-44</option>
                        <option value="45-49">45-49</option>
                        <option value="50-54">50-54</option>
                        <option value="55-59">55-59</option>
                        <option value="60-64">60-64</option>
                        <option value="65-69">65-69</option>
                        <option value="70-74">70-74</option>
                        <option value="75-79">75-79</option>
                        <option value="80-84">80-84</option>
                        <option value="85-89">85-89</option>
                        <option value="90-94">90-94</option>
                        <option value="95-99">95-99</option>
                    </x-select>
                    <x-select id="sex" label="Jenis Kelamin" name="sex" isFit="" required>
                        <option value="1" selected>Laki - Laki</option>
                        <option value="2">Perempuan</option>
                    </x-select>
                </div>

                {{-- transmission_id, year --}}
                <div class="xl:grid grid-cols-2 gap-x-3">
                    <x-select id="transmission_id" label="Transmisi" name="transmission_id" isFit="" required>
                        @foreach ($transmissions as $transmission)
                            <option value="{{ $transmission->id }}">{{ $transmission->name }}</option>
                        @endforeach
                    </x-select>
                    <x-select id="year" label="Tahun" name="year" isFit="" required>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="text-end">
                <x-button>
                    Kirim Data
                </x-button>
            </div>
        </form>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
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

                $('#regency_id').on('change', function() {
                    let regencyId = $(this).val();
                    $.ajax({
                        url: "{{ route('admin.bank.get-district') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            regency_id: regencyId
                        },
                        success: function(response) {
                            let data = response;
                            let html = '';
                            data.forEach(function(item) {
                                html += `<option value="${item.id}">${item.name}</option>`;
                            });
                            $('#district_id').html(html);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
