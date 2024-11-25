@props(['disabled' => false])

<textarea {!! $attributes->merge([
    'class' =>
        'w-full p-2.5 text-sm border rounded-lg text-text bg-border/50 border-border focus:border-accent focus:ring-accent disabled:bg-border/50 disabled:border-transparent',
]) !!} {{ $disabled ? 'disabled' : '' }}>{{ $slot }}</textarea>
