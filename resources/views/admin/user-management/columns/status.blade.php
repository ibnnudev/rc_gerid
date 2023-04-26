@if ($is_active == 1)
    <span class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white">
        <i class="fas fa-check-circle w-4 h-4 text-green-500 transition duration-75 dark:text-gray-400"></i>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">Aktif</span>
    </span>
@else
    <span class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white">
        <i class="fas fa-times-circle w-4 h-4 text-red-500 transition duration-75 dark:text-gray-400"></i>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">Tidak Aktif</span>
    </span>
@endif
