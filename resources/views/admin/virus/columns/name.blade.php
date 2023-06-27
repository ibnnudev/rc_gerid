<div class="flex items-center space-x-4">
    <div class="flex-shrink-0">
        <img class="w-8 h-auto rounded-full"
            src="{{ $virus->image ? asset('storage/virus/' . $virus->image) : asset('images/noimage.jpg') }}"
            alt="Neil image">
    </div>
    <div class="flex-1 min-w-0">
        <p class="font-medium text-gray-900 dark:text-white">
            {{ $virus->name }}
        </p>
    </div>
</div>
