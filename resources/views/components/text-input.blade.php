@props(['disabled' => false, 'type' => 'text', 'errors', 'label' => false])


@php
    $errorClasses = 'border-red-600 focus:border-red-600 ring-1 ring-red-600 focus:ring-red-600 w-full';
    $defaultClasses = '';
    $successClasses = 'border-emerald-500 focus:border-emerald-500 ring-1 ring-emerald-500 focus:ring-emerald-500 w-full';
    $attributeName = preg_replace('/(\w+)\[(\w+)]/', '$1.$2', $attributes['name']);
@endphp
<div>
    @if ($label)
        <label>{{ $label }}</label>
    @endif
    @if ($type === 'select')
        <select {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" {!! $attributes->merge([
            'class' =>
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full' .
                ($errors->has($attributeName) ? $errorClasses : (old($attributeName) ? $successClasses : $defaultClasses)),
        ]) !!}>
            {{ $slot }}
        </select>
    @else
        <input {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" {!! $attributes->merge([
            'class' =>
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full' .
                ($errors->has($attributeName) ? $errorClasses : (old($attributeName) ? $successClasses : $defaultClasses)),
        ]) !!}>
    @endif

    @error($attributeName)
        <small class="text-red-600 block">{{ $message }}</small>
    @enderror
</div>
