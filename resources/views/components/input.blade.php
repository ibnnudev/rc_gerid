@props(['label' => '', 'name' => '', 'required' => false, 'tip' => '', 'type' => 'text'])

<div class="form-control input-{{ $name }}">
    <label class="label">
        <span class="font-medium lg:text-xs text-xs text-gray-700 2xl:label-text">{{ $label }}
            {!! $required == true ? '<sup class="text-error">*</sup>' : '' !!}</span>
    </label>
    <input name="{{ $name }}" type="{{ $type }}" {!! $attributes->merge([
        'class' => 'border-gray-300 focus:border-primary text-xs lg:text-xs focus:ring-primary rounded-md shadow-sm',
    ]) !!} />
    @if ($tip)
        <label class="label">
            <span class="label-text-alt">{{ $tip }}</span>
        </label>
    @endif
    @error($name)
        <label class="label">
            <small class="label-text-alt text-error">{{ $message }}</small>
        </label>
    @enderror
</div>
