<x-app-layout>
    <x-breadcrumbs name="hiv-cases.show" :data="$case" />
    <h1 class="font-semibold text-lg my-8">Tambah Kasus</h1>

    <x-card-container>
        <div class="xl:grid grid-cols-3 gap-x-3">
            {{-- idkd, idkd address, lat, long --}}
            <x-input autocomplete="off" id="idkd" name="idkd" label="IDKD" type="text"
                tip="(Nama-Tahun-Tanggal-Bulan)" :value="$case->idkd" required disabled />
            <x-input autocomplete="off" id="idkd_address" :value="$case->idkd_address" name="idkd_address" label="Alamat IDKD" type="text"
                required disabled />
            <div class="grid grid-cols-2 gap-x-3">
                <x-input autocomplete="off" id="latitude" name="latitude" :value="$case->latitude" label="Latitude" type="text" required disabled />
                <x-input autocomplete="off" id="longitude" name="longitude" :value="$case->longitude" label="Longitude" class="max-xs-auto"
                    type="text" required disabled />
            </div>

            {{-- province_id, regency_id, dictrict_id, region --}}
            <x-select id="province_id" label="Provinsi" name="province_id" isFit="" required disabled>
                <option value="">{{$case->province->name}}</option>
            </x-select>
            <x-select id="regency_id" label="Kota/Kabupaten" name="regency_id" isFit="" required disabled>
                <option value="">{{$case->regency->name}}</option>
            </x-select>
            <div class="xl:grid grid-cols-2 gap-x-3">
                <x-select id="district_id" label="Kecamatan" name="district_id" isFit="" required disabled>
                    <option value="">{{$case->district->name}}</option>
                </x-select>
                <x-select id="region" label="Bagian" name="region" isFit="" required disabled>
                    <option value="">{{$case->region}}</option>
                </x-select>
            </div>

            {{-- count_of_cases, age, age_group, sex --}}
            <div class="xl:grid grid-cols-2 gap-x-3">
                <x-input autocomplete="off" id="count_of_cases" name="count_of_cases" label="Jumlah Kasus"
                    type="number" :value="$case->count_of_cases" required disabled />
                <x-input autocomplete="off" id="age" name="age" label="Usia" type="number" :value="$case->age" required disabled />
            </div>
            <div class="xl:grid grid-cols-2 gap-x-3">
                <x-select id="age_group" label="Kelompok Usia" name="age_group" isFit="" required disabled>
                    <option value="">{{$case->age_group}}</option>
                </x-select>
                <x-select id="sex" label="Jenis Kelamin" name="sex" isFit="" required disabled>
                    <option value="">
                        {{$case->sex == 1 ? 'Laki - Laki' : 'Perempuan'}}
                    </option>
                </x-select>
            </div>

            {{-- transmission_id, year --}}
            <div class="xl:grid grid-cols-2 gap-x-3">
                <x-select id="transmission_id" label="Transmisi" name="transmission_id" isFit="" required disabled>
                    <option value="">{{$case->transmission->name}}</option>
                </x-select>
                <x-select id="year" label="Tahun" name="year" isFit="" required disabled>
                    <option value="">{{$case->year}}</option>
                </x-select>
            </div>
        </div>

        {{-- back --}}
        <div class="mt-4 text-end">
            <x-link-button route="{{ route('admin.hiv-case.index') }}" color="gray">
                Kembali
            </x-link-button>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
            });
        </script>
    @endpush
</x-app-layout>
