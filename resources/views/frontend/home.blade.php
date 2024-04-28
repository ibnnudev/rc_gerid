<x-guest-layout>
    @push('css-internal')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
                <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
                    Indonesian Database For Genomic Information
                </div>
                <div class="px-6 py-8">
                    <div class="swiper h-full w-[300px] md:w-[650px] lg:w-full">
                        <div class="swiper-wrapper">
                            @forelse ($slides as $slide)
                                <div class="swiper-slide">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                        <div class="col-span-8">
                                            <h1 class="font-semibold text-sm">
                                                {{ $slide->title }}
                                            </h1>
                                            <div
                                                class="space-y-3 text-gray-600 text-sm mt-3 overflow-hidden h-[17em] text-justify leading-6">
                                                {!! Str::words(html_entity_decode($slide->content), 60, '...') !!}
                                                <p class="text-blue-500 font-medium hover:underline">
                                                    <a href="{{ route('slide.show', $slide->slug) }}">Selengkapnya</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-span-4 flex justify-end items-start">
                                            <img src="{{ asset('storage/slides/' . $slide->image) }}" alt=""
                                                height="200" width="200"
                                                class="object-contain rounded-lg cursor-pointer"
                                                onclick="window.open('{{ asset('storage/slides/' . $slide->image) }}', '_blank')">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="flex justify-center items-center">
                                    <p class="text-gray-500">Slide belum tersedia</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination justify-end flex"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-4 space-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl shadow">
                    <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-md">
                        Jumlah Sekuen
                    </div>
                    <div>
                        <div class="text-center text-3xl font-semibold text-gray-700 py-6">
                            {{ number_format($currentTotalSample, 0, ',', '.') }}
                            <p class="text-xs text-gray-500">Periode tahun {{ $rangeSample->keys()->first() }} -
                                {{ $rangeSample->keys()->last() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow">
                    <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-md">
                        Jumlah Publikasi
                    </div>
                    <div>
                        <div class="text-center text-3xl font-semibold text-gray-700 py-6">
                            {{ number_format($totalCitation, 0, ',', '.') }}
                            <p class="text-xs text-gray-500">Kontribusi Peneliti</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow">
                <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-md">
                    Kunjungi INDAGI Phylodynamic Platform
                </div>
                <div class="p-6">
                    <a href="http://phylo.indagi.rc-gerid.unair.ac.id">
                        <img src="{{ asset('assets/application/phylo.png') }}" class="w-full h-32 object-contain"
                            alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <div class="bg-blue-200 border border-gray-200 rounded-lg lg:col-span-2 p-6 shadow-sm">
            <h1 class="font-semibold text-lg mb-3">Daftar Genome Virus</h1>
            <div class="grid lg:grid-cols-3 gap-6">
                @foreach ($sampleGroupByVirus as $data)
                    <div class="bg-white rounded-lg h-full">
                        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-3 text-sm font-semibold">
                            {{ $data->name }}
                        </div>
                        <div class="text-center p-6">
                            <p class="text-sm text-gray-600">Total Sekuen</p>
                            <h1 class="text-xl font-bold">
                                {{ $data->samples }}
                            </h1>
                            <a href="{{ route('detail-virus', $data->name) }}"
                                class="text-xs text-blue-500 hover:underline font-medium">Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="grid lg:grid-cols-2 gap-6 h-fit p-6 bg-white rounded-lg shadow">
            <div class="bg-white border border-gray-200 rounded-xl h-fit">
                <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-3 text-sm font-semibold">
                    Total Pengguna
                </div>
                <div class="text-center p-6">
                    <h1 class="text-xl font-bold">
                        {{ $totalUser }}
                    </h1>
                    <p class="text-xs">
                        {{ $newUserToday }} pengguna baru <br>hari ini
                    </p>
                </div>
            </div>
            <div class="border border-gray-200 rounded-xl h-fit">
                <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-3 text-sm font-semibold">
                    Total Pengunjung
                </div>
                <div class="p-6">
                    <h1 class="text-xl font-bold text-center">
                        {{ $totalVisitor }}
                    </h1>
                    <div class="mt-2">
                        <p class="text-xs mb-1">
                            Berdasarkan negara
                        </p>
                        @foreach ($visitorByCountry as $key => $value)
                            <div class="text-xs text-gray-600 flex space-x-2 items-center">
                                <img src="https://flagsapi.com/{{ $key }}/flat/64.png"
                                    class="mr-1 w-auto h-6">
                                <p>:
                                    {{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs mt-2">
                        {{ $newVisitorToday }} pengunjung baru <br>hari ini
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('js-internal')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            // auto slide
            const swiper = new Swiper('.swiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        return '<span class="' + className + '"></span>';
                    },
                },
            })
        </script>
    @endpush
</x-guest-layout>
