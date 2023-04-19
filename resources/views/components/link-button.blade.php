@props(['route' => '#', 'color' => 'green', 'id' => '', 'target' => '_self'])

<a href="{{ $route }}" {!! $attributes->merge([
    'class' =>
        'inline-flex h-fit items-center px-4 py-2 border border-transparent rounded-md lg:text-xs text-white bg-' .
        $color .
        '-800 hover:bg-' .
        $color .
        '-600 focus:bg-' .
        $color .
        '-600 active:bg-' .
        $color .
        '-900 focus:outline-none focus:ring-2 focus:ring-' .
        $color .
        '-500 focus:ring-offset-2 transition ease-in-out duration-150',
]) !!} id="{{ $id }}"
    target="{{ $target }}">{{ $slot }}</a>
