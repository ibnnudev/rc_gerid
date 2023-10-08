@extends('frontend.layout')
<style>
    table.dataTable td {
        word-break: break-word;
    }
</style>
@section('content')
    <section class="px-5 py-2 align-top ">
        <p id="tableInfo" class="pt-2"></p>
        <form action="{{ route('downloadFasta') }}" method="get">
            <div class="dt-responsive table-responsive">
                <table class="table nowrap" style="border:none" id="samplesTable">
                    <thead style="display: none">
                        <tr>
                            <th style="width: 1em">Column 1</th>
                            <th style="width: 90%; background-color: red">Column 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listCitations as $item)
                            <tr>
                                <td style="width: 1;border:none" class="align-top">
                                    <input class="form-check-input" type="checkbox" id="id_fasta" name="fasta[]"
                                        value="{{ $item['id_citation'] }}" class="id_fasta">
                                    <p class="text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td style="width: 10px;  ">
                                    <div class="text-start">
                                        <div class="mb-1 text-xs text-gray-400">{{ $item['user'] }}</div>
                                        <div class="container-title">
                                            <a href="{{ route('detailCitation', $item['id_citation']) }}"
                                                class="text-blue-500"
                                                style="word-break: break-word;white-space:normal;">{{ $item['title'] }}</a>
                                        </div>
                                        <h6 class="pb-0">{{ $item['province'] . ',' . $item['regency'] }}</h6>
                                        <p>{{ $item['author']['name'] . ',' . $item['author']['member'] }} |
                                            {{ $item['monthYear'] }}</p>
                                        <span class="text-gray-400">Accession NCBI :
                                            {{ $item['accession_ncbi'] }}</span><span class="text-gray-400"> | Accession
                                            INDAGI : {{ $item['accession_indagi'] }}</span>
                                        <h6><a href="{{ route('detailFasta', $item['id_citation']) }}"
                                                class="text-blue-500">Fasta</a> </h6>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="download" id="download" type="submit" class="hover:text-blue-800">Download
                    selected</button>
        </form>
        </div>
    </section>
@endsection
@push('js-internal')
    <script>
        $(function() {
            $('#search-dropdown').on('keyup', function() {
                if ($(this).val() == '') {
                    $('button[type="submit"]').prop('disabled', true);
                } else {
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
        $(function() {
            var table = $('#samplesTable').DataTable({
                responsive: true,
                dom: 'rtp'
            });
            var info = table.page.info();
            console.log(info);
            $('#tableInfo').html(
                'Items : ' + (info.page + 1) + ' to ' + info.length + ' of ' + info.pages
            );
        });
        // var checkboxes = document.querySelectorAll("input[type=checkbox]");
        // var submit = document.getElementById("download");

        // function getChecked() {
        //     var checked = [];

        //     for (var i = 0; i < checkboxes.length; i++) {
        //         var checkbox = checkboxes[i];
        //         if (checkbox.checked) checked.push(checkbox.value);
        //     }

        //     return checked;
        // }

        // submit.addEventListener("click", function() {
        //     var checked = getChecked();
        //     downloadFasta(checked)
        // });

        // function downloadFasta(params) {
        //     $.ajax({
        //         url: "{{ route('downloadFasta') }}",
        //         type: "GET",
        //         data: {
        //             fasta_id: params
        //         },
        //         dataType: "text",
        //         success: function(response) {
        //             // console.log('response');
        //             return response;
        //         download("hello.txt","This is the content of my file :)");  

        //         }
        //     });
        // }

        // function download(filename, text) {
        //     var element = document.createElement('a');
        //     element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        //     element.setAttribute('download', filename);

        //     element.style.display = 'none';
        //     document.body.appendChild(element);

        //     element.click();

        //     document.body.removeChild(element);
        // }

        // Start file download.
    </script>
@endpush
