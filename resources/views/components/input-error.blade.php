@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'bg-red-600 rounded py-3 px-4 text-sm text-white space-y-1 mb-2']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
