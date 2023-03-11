@props(['id' => '', 'name' => '', 'label' => '', 'isFit' => true])

<div class="form-control w-full {{ $isFit == true ? 'max-w-xs' : '' }}">
    <label class="label">
        <span class="label-text font-medium">{{ $label }}</span>
    </label>
    <select name="{{ $name }}" id="{{ $id }}" {!! $attributes->merge([
        'class' => 'select select-bordered',
    ]) !!}>
        {{ $slot }}
    </select>
    <label class="label">
        @error($name)
            <span class="label-text-alt text-error">{{ $message }}</span>
        @enderror
    </label>
</div>
