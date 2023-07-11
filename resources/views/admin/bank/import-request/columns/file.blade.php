<div class="">
    <div>
        <a class="text-primary" href="{{ asset('storage/import-request/' . $data->filename) }}" target="_blank">
            {{-- <i class="fas fa-file-excel mr-2"></i> --}}
            Unduh File Sekuen
        </a>
    </div>
    <div>
        <p class="text-gray-900 dark:text-white">
            Di impor oleh: {{ $data->importedBy->name }}
        </p>
    </div>
</div>
