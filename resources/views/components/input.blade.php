@props(['label' => '', 'name' => '', 'required' => false])

<div class="form-control input-{{ $name }}">
    <label class="label">
        <span class="font-medium lg:text-xs text-gray-700 2xl:label-text">{{ $label }} {!! $required == true ? '<sup class="text-error">*</sup>' : '' !!}</span>
    </label>
    <input name="{{ $name }}" {!! $attributes->merge([
        'class' => 'border-gray-300 focus:border-primary lg:text-xs focus:ring-primary rounded-md shadow-sm',
    ]) !!} />
    <label class="label">
        @error($name)
            <span class="label-text-alt text-error">{{ $message }}</span>
        @enderror
    </label>
</div>
