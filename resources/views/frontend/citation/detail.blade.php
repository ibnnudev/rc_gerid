<x-guest-layout>
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
            Detail Informasi Sitasi
        </div>
        <div class="px-6 py-8">
            <h1 class="font-semibold">{{ $citation['title'] }}</h1>
            <p class="mt-2">Kode sampel: {{ $citation['accession_ncbi'] }}</p>
            <div class="grid gap-6">
                <div class="">
                    <table class="text-sm mt-4 leading-6">
                        <tr>
                            <td class="font-medium">REFERENCE</td>
                            <td style="padding-left: 1em"></td>
                        </tr>
                        <tr>
                            <td class="text-end uppercase">AUTHOR</td>
                            <td style="padding-left: 1em">
                                <p class="text-blue-700">
                                    <a href="http://www.google.com/search?q={{ $citation['author']['name'] . ',' . $citation['author']['member'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer">{{ $citation['author']['name'] . ',' . $citation['author']['member'] }}
                                    </a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end uppercase"> TITLE</td>
                            <td style="padding-left: 1em">
                                <p class="text-blue-700">
                                    <a href="https://www.google.com/search?q={{ $citation['title'] }}" target="_blank">
                                        {{ $citation['title'] }}
                                    </a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-medium">FEATURE </td>
                            <td style="padding-left: 1em"></td>
                        </tr>
                        <tr>
                            <td class="text-end uppercase">virus</td>
                            <td style="padding-left: 1em">
                                <p class="m-0">{{ $virus->name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end uppercase">sampel</td>
                            <td style="padding-left: 1em">
                                <p class="m-0">{{ $citation['accession_ncbi'] }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end uppercase">gene</td>
                            <td style="padding-left: 1em">
                                <p class="m-0">{{ $citation['gene_name'] }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="">
                    <div class="md:flex justify-between items-center w-fit mb-3">
                        <h1 class="font-semibold mr-6">Fasta</h1>
                    </div>
                    <div class="text-sm w-fit" id="fasta">
                        {!! $fasta !!}
                    </div>
                    <br>
                    <span onclick="print()" class="text-blue-600 hover:underline cursor-pointer">Unduh</span>
                </div>
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
