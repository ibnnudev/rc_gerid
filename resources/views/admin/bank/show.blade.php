<x-app-layout>
    <x-breadcrumbs name="bank.show" :data="$sample" />
    <h1 class="font-semibold text-lg my-8">Detail</h1>

    <x-card-container>
        <form action="{{ route('admin.bank.store') }}" method="POST">
            @csrf
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <div>
                    <div class="lg:flex gap-x-3 lg:gap-3">
                        <div class="lg:w-1/2">
                            <x-select name="pickup_month" label="Bulan" id="pickup_month" class="form-select w-full"
                                required>
                            </x-select>
                        </div>
                        <div class="lg:w-1/2">
                            <x-select name="pickup_year" label="Tahun" id="pickup_year" class="form-select w-full"
                                required>
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
                </x-select>
                <x-select id="regency_id" label="Kota/Kabupaten" name="regency_id" isFit="" required>
                </x-select>
                <x-input id="place" label="Tempat Pengambilan Sampel" :value="$sample->place ?? null" name="place"
                    type="text" required />
                <x-input id="title" label="Judul Artikel" name="title" :value="$sample->citation->title ?? null" type="text"
                    required />
                <x-select id="authors_id" label="Nama Penulis" name="authors_id" isFit="" required>
                </x-select>
            </div>
            <hr>
            <div class="md:grid md:grid-cols-3 gap-x-4">
                <x-input id="sample_code" label="Kode Sampel" :value="$sample->sample_code ?? null" name="sample_code" type="text"
                    required />
                <x-select id="viruses_id" label="Nama Virus" name="viruses_id" isFit="false" required>
                </x-select>
                <x-select id="genotipes_id" label="Genotipe & Subtipe" name="genotipes_id" isFit="false" required>
                </x-select>
                <x-input id="gene_name" label="Nama Gen" :value="$sample->gene_name ?? null" name="gene_name" type="text" required />
                <div class="col-span-2 ">
                    <x-textarea id="sequence_data" label="Data Sekuen" name="sequence_data" required>
                        {{ $sample->sequence_data ?? null }}</x-textarea>
                </div>
            </div>

            {{-- back --}}
            <div class="mt-4 text-end">
                <x-link-button route="{{ route('admin.bank.index') }}" color="gray">
                    Kembali
                </x-link-button>
            </div>

        </form>
    </x-card-container>
    @push('js-internal')
        <script>
            $('document').ready(function() {
                let pickup_month, pickup_year, pickup_date;
                pickup_date = @json(date('M-Y', strtotime($sample->pickup_date)));
                pickup_month = pickup_date.split('-')[0];
                pickup_year = pickup_date.split('-')[1];
                // add option to select
                $('#pickup_month').append(`<option value="${pickup_month}" selected>${pickup_month}</option>`);
                $('#pickup_year').append(`<option value="${pickup_year}" selected>${pickup_year}</option>`);

                $('#authors_id').append(
                    `<option value="${@json($sample->citation->authors_id)}" selected>${@json($sample->citation->author->name)}</option>`
                );

                $('#province_id').append(
                    `<option value="${@json($sample->province_id)}" selected>${@json($sample->province->name ?? null)}</option>`
                );
                $('#regency_id').append(
                    @if ($sample->regency_id != null)
                        `<option value="${@json($sample->regency_id)}" selected>${@json($sample->regency->name ?? null)}</option>`
                    @else
                        `<option value="" selected>Pilih Kota/Kabupaten</option>`
                    @endif
                );
                $('#viruses_id').append(
                    `<option value="${@json($sample->viruses_id)}" selected>${@json($sample->virus->name ?? null)}</option>`
                );
                $('#genotipes_id').append(
                    `<option value="${@json($sample->genotipes_id)}" selected>${@json($sample->genotipe->genotipe_code ?? null)}</option>`
                );

                // set all select2 disabled
                $('select').prop('disabled', true);
                // set all input disabled
                $('input').prop('disabled', true);
                // set all textarea disabled
                $('textarea').prop('disabled', true);

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
