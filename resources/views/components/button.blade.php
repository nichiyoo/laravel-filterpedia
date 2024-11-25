@props(['type' => 'button', 'variant' => 'default', 'disabled' => false])

@php
  $cvariant = match ($variant) {
      'primary' => 'border-transparent text-background bg-accent hover:text-light hover:bg-hover',
      'secondary' => 'border-transparent text-background bg-primary hover:text-light hover:bg-hover',
      'outline' => 'text-primary border-primary hover:text-background hover:border-transparent hover:bg-primary',
      'ghost' => 'border-transparent text-text bg-border/50 hover:text-light hover:bg-hover',
      'danger' => 'border-transparent text-text bg-border/50 hover:text-light hover:bg-red-600',
      'default' => 'border-transparent text-background bg-accent hover:text-light hover:bg-hover',
  };
@endphp

<button
  {{ $attributes->merge([
      'type' => $type,
      'class' => "px-6 py-2.5 text-sm border font-medium duration-200 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed {$cvariant}",
      'disabled' => $disabled,
  ]) }}>
  {{ $slot }}
</button>
