<x-guest-layout>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
                <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
                    Indonesian Database For Genomic Information
                </div>
                <div class="px-6 py-8">
                    <swiper-container>
                        <swiper-slide>
                            <div class="grid grid-cols-12">
                                <div class="col-span-8">
                                    <h1 class="font-semibold text-sm">RESEARCH CENTER ON GLOBAL EMERGING AND
                                        RE-EMERGING
                                        INFECTIOUS DISEASE, INSTITUTE OF TROPICAL DISEASE, UNIVERSITAS AIRLANGGA</h1>
                                    <div class="space-y-3 text-gray-600 text-xs mt-10">
                                        <p class="leading-5">
                                            Indonesia Database For Genomic Information (INDAGI) adalah aplikasi website
                                            yang dikembangkan oleh Research Center on Global Emerging and Re-emerging
                                            Infectious Diseases (RC-GERID) Institute of Tropical Disease (ITD)
                                            Universitas Airlangga, Surabaya.
                                        </p>
                                        <p class="leading-5">
                                            Indonesia dengan tujuan untuk mengakomodasi informasi sekuen dari patogen
                                            penyebab penyakit infeksi emerging dan re-emerging khususnya isolat yang
                                            didapatkan di Indonesia, antara lain virus HIV, Hepatitis B dan C, Dengue,
                                            Influenza, Rotavirus dan Norovirus
                                        </p>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <img src="{{ asset('assets/application/indagi.png') }}" alt="">
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper-container>
                </div>
            </div>
        </div>
        <div class="col-span-4 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl shadow">
                    <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-sm">
                        Jumlah Sekuen
                    </div>
                    <div>
                        <div class="text-center text-3xl font-semibold text-gray-700 py-6">
                            1.000
                            <p class="text-xs text-gray-500">Periode tahun 2023</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow">
                    <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-sm">
                        Jumlah Publikasi
                    </div>
                    <div>
                        <div class="text-center text-3xl font-semibold text-gray-700 py-6">
                            1.000
                            <p class="text-xs text-gray-500">Kontribusi Peneliti</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow">
                <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-sm">
                    Photogenic Tree
                </div>
                <div class="p-6">
                    {{-- TODO: make it dynamic --}}
                    <a href="/">
                        <img src="{{ asset('assets/application/phylo.png') }}" class="w-full h-32" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-6 gap-6 mt-5">
        @foreach ($sampleGroupByVirus as $data)
            <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
                <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-3 text-sm font-semibold">
                    {{ $data->name }}
                </div>
                <div class="text-center p-6">
                    <p class="text-sm text-gray-600">Total Sekuen</p>
                    <h1 class="mb-2 text-xl font-bold">
                        {{ $data->samples }}
                    </h1>
                    <a href="{{ route('detail-virus', $data->name) }}"
                        class="text-xs text-blue-500 hover:underline font-medium">Selengkapnya</a>
                </div>
            </div>
        @endforeach
    </div>

    @push('js-internal')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    @endpush
</x-guest-layout>
