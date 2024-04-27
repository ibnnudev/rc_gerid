<x-guest-layout>
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
            Detail Informasi Sitasi
        </div>
        <div class="px-6 py-8">
            <h1 class="font-semibold">{{ $citation['title'] }}</h1>
            <p class="mt-2">Kode sampel: {{ $citation['accession_ncbi'] }}</p>
            <p class="uppercase my-3">REFERENCE</p>
            <div class="space-y-4 md:space-y-0 gap-4 mt-4">
                <h1 class="font-semibold uppercase">Author</h1>
                <div>
                    <a href="http://www.google.com/search?q={{ $citation['author']['name'] . ',' . $citation['author']['member'] }}"
                        target="_blank" class="text-blue-500 hover:underline"
                        rel="noopener noreferrer">{{ $citation['author']['name'] . ',' . $citation['author']['member'] }}
                    </a>
                </div>
            </div>
            <div class="space-y-4 md:space-y-0 gap-4 mt-4">
                <h1 class="font-semibold uppercase">title</h1>
                <div>
                    <a href="https://www.google.com/search?q={{ $citation['title'] }}" target="_blank" class="block">
                        {{ $citation['title'] }}
                    </a>
                </div>
            </div>
            <div class="space-y-4 md:space-y-0 gap-4 mt-4">
                <h1 class="font-semibold uppercase">feature</h1>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="space-y-4 mt-4">
                        <h1 class="capitalize">Virus</h1>
                        <p>{{ $virus->name }}</p>
                    </div>
                    <div class="space-y-4 mt-4">
                        <h1 class="capitalize">sample</h1>
                        <p>{{ $citation['accession_ncbi'] ?? '-' }}</p>
                    </div>
                    <div class="space-y-4 mt-4">
                        <h1 class="capitalize">gene</h1>
                        <p>{{ $citation['gene_name'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="">
                <h1 class="font-semibold mr-6">Fasta</h1>
                <div class="text-sm hidden md:block lowercase" id="fasta">
                    {!! htmlspecialchars_decode($fasta) !!}
                </div>
                <span onclick="print()" class="text-blue-600 hover:underline cursor-pointer">Unduh Fasta</span>
            </div>
        </div>
    </div>
    @push('js-internal')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script>
            let citation = @json($citation);

            function print() {
                var fasta = document.getElementById('fasta').innerText;
                var blob = new Blob([fasta], {
                    type: "text/plain;charset=utf-8"
                });
                saveAs(blob, "fasta" + citation.accession_ncbi + citation.accession_indagi + new Date().getTime() + ".txt");
            }
        </script>
    @endpush
</x-guest-layout>
