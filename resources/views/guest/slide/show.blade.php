<x-guest-layout>
    @push('css-internal')
        <style>
            .video {
                position: relative;
                padding-bottom: 38%;
                padding-top: 25px;
                height: 0;
            }

            .video iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 400px;
                border-radius: 15px;
            }
        </style>
    @endpush
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full max-w-6xl mx-auto">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6">
            {{ $data->title }}
        </div>
        <div class="px-6 py-8">
            <div class="md:grid grid-cols-3 mb-4 gap-4">
                @if ($data->video != null)
                    <div class="col-span-3 mt-4 video">
                        {!! $data->video !!}
                    </div>
                @endif
                <div class="mb-4 col-span-2 text-justify">{!! $data->content !!}</div>
                <div class="md:flex justify-end hidden">
                    <img src="{{ asset('storage/slides/' . $data->image) }}"
                        class="w-full h-auto md:w-40 md:h-40 lg:w-72 lg:h-72 object-cover rounded-lg overflow-hidden cursor-pointer"
                        alt="{{ $data->slug }}"
                        onclick="window.open('{{ asset('storage/slides/' . $data->image) }}', '_blank')">
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
