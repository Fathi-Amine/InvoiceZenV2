@props(['disabled' => false, 'errors', 'label' => false])
@if ($label)
    <label>{{ $label }}</label>
@endif

@php
    $errorClasses = 'border-red-600 focus:border-red-600 ring-1 ring-red-600 focus:ring-red-600';
    $defaultClasses = '';
    $successClasses = 'border-emerald-500 focus:border-emerald-500 ring-1 ring-emerald-500 focus:ring-emerald-500';
@endphp
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' .
        ($errors->has($attributes['name'])
            ? $errorClasses
            : (old($attributes['name'])
                ? $successClasses
                : $defaultClasses)),
]) !!}>

@error($attributes['name'])
    <small class="text-red-600 ">{{ $message }}</small>
@enderror
