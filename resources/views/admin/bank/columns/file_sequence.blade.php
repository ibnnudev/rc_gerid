<a href="{{ $sample->sequence_data_file ? asset('storage/sequence_data/' . $sample->sequence_data_file) : asset('images/noimage.jpg') }}"
    target="_blank">
    @if ($sample->sequence_data_file)
        <span
            class="text-primary">{{
                // replace the file name with 'File'
                str_replace($sample->sequence_data_file, 'File Sequence', $sample->sequence_data_file)
            }}
        </span>
    @else
        No File
    @endif
</a>
