<x-guest-layout>
    @push('css-internal')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8">
            <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
                <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
                    Indonesian Database For Genomic Information
                </div>
                <div class="px-6 py-8">
                    <div class="swiper h-full">
                        <div class="swiper-wrapper">
                            @forelse ($slides as $slide)
                                <div class="swiper-slide">
                                    <div class="grid grid-cols-12">
                                        <div class="col-span-8">
                                            <h1 class="font-semibold text-sm">
                                                {{ $slide->title }}
                                            </h1>
                                            <div class="space-y-3 text-gray-600 text-xs mt-10">
                                                {!! html_entity_decode($slide->content) !!}
                                            </div>
                                        </div>
                                        <div class="col-span-4">
                                            <img src="{{ asset('storage/slides/' . $slide->image) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="flex justify-center items-center">
                                    <p class="text-gray-500">Slide belum tersedia</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
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
                            {{ number_format($currentTotalSample, 0, ',', '.') }}
                            <p class="text-xs text-gray-500">Periode tahun {{ $rangeSample->keys()->first() }} -
                                {{ $rangeSample->keys()->last() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow">
                    <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-sm">
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
                <div href="#" class="rounded-t-xl bg-blue-200 text-gray-700 py-3 px-6 font-medium text-sm">
                    Photogenic Tree
                </div>
                <div class="p-6">
                    <a href="http://phylo.indagi.rc-gerid.unair.ac.id">
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
                    position: 'bottom',
                },
            })
        </script>
    @endpush
</x-guest-layout>
