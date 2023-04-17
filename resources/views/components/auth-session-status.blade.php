@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-white bg-green-600 py-3 px-4 rounded']) }}>
        {{ $status }}
    </div>
@endif
