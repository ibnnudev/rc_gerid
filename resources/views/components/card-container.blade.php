@props(['header' => '', 'id' => '', 'bgColor' => 'bg-white', 'padding' => true])

<div class="py-2" id="{{ $id }}">
    <div class="mx-auto">
        <div
            class="{{ $bgColor == 'bg-transparent' ? 'bg-transparent' : $bgColor . ' border-b border-gray-200 shadow-sm' }} overflow-hidden sm:rounded-2xl shadow-xl">
            <div class="{{ $padding == true ? 'p-4' : '' }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

