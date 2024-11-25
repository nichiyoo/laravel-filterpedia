@props(['disabled' => false])

<input {!! $attributes->merge([
    'class' =>
        'form-input w-full p-2.5 text-sm border rounded-lg text-text bg-border/50 border-border focus:border-accent focus:ring-accent disabled:bg-border disabled:border-transparent',
]) !!} {{ $disabled ? 'disabled' : '' }}>
