<div class="">
    <div>
        <a class="text-primary" target="_blank"
            onclick="
            event.preventDefault();
            window.open('{{ asset('storage/import-request/' . $data->filename) }}', '_blank');
            ">
            Unduh File Sekuen
        </a>
    </div>
    <div>
        <p class="text-gray-900 dark:text-white">
            Di impor oleh: {{ $data->importedBy->name }}
        </p>
    </div>
</div>
