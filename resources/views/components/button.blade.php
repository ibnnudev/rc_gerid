@props(['color' => 'green', 'type' => 'submit'])

<button
    {{ $attributes->merge([
        'type' => $type == 'submit' ? 'submit' : 'button',
        'class' =>
            'inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm text-white bg-' .
            $color .
            '-600 hover:bg-' .
            $color .
            '-500 focus:outline-none focus:ring-2 focus:ring-' .
            $color .
            '-500 focus:ring-offset-2 transition ease-in-out duration-150 ',
    ]) }}>
    {{ $slot }}
</button>
