<x-app-layout>
    <x-breadcrumbs name="bank.create" />
    <h1 class="font-semibold text-xl my-8">Tambah Data</h1>

    <x-card-container>
        <form action="" method="POST">
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input-single-datepicker id="pickup_date" label="Tanggal Pengumpulan Sampel" name="pickup_date" type="text" required />
                <x-select id="region" label="Provinsi" name="region" isFit="" required>
                    <option value="">Jawa Timur</option>
                </x-select> 
                <x-select id="city" label="Kota/Kabupaten" name="city" isFit="" required>
                    <option value="">Surabaya</option>
                </x-select> 
                <x-input id="place" label="Tempat Pengambilan Sampel" name="place" type="text" required />
                <x-input id="title" label="Judul Artikel" name="title" type="text" required />
                <x-select id="authors_id" label="Nama Penulis" name="authors_id" isFit="" required>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <hr>
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input id="sample_code" label="Kode Sampel" name="sample_code" type="text" required />
                <x-select id="viruses_id" label="Nama Virus" name="viruses_id" isFit="" required>
                    @foreach ($viruses as $virus)
                        <option value="{{ $virus->id }}">{{ $virus->name }}</option>
                    @endforeach
                </x-select>
                <x-select id="genotipes_id" label="Genotipe & Subtipe" name="genotipes_id" isFit="" required>
                    <option value="">CRF01_AE</option>
                </x-select> 
                <x-input id="gene_name" label="Nama Gen" name="gene_name" type="text" required />
                <div class="col-span-2 ">
                    <x-textarea id="sequence_data" label="Data Sekuen" name="sequence_data" required/></textarea>
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
    $('document').ready(function(){
        $('select').select2();
    });
    </script>
@endpush
</x-app-layout>
