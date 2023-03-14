@props(['label' => '', 'name' => '', 'required' => false])

<div class="form-control">
    <label class="label" for="{{ $name }}">
        <span class="font-medium lg:text-xs text-gray-700">{{ $label }} {!! $required == true ? '<sup class="text-error">*</sup>' : '' !!}</span>
    </label>
    <textarea {!! $attributes->merge([
        'class' => 'h-24 border-gray-300 focus:border-primary text-xs focus:ring-primary rounded-md shadow-sm',
    ]) !!} id="{{ $name }}" name="{{ $name }}">{{ $slot }}</textarea>
    <label class="label">
        @error($name)
            <span class="label-text-alt text-error">{{ $message }}</span>
        @enderror
    </label>
</div>
