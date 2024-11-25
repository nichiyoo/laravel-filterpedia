@props(['icon' => 'layout-grid', 'label' => 'Keranjang', 'variant' => 'default'])

@php
  $cvariant = match ($variant) {
      'primary' => 'text-primary bg-background hover:bg-primary hover:text-light',
      'secondary' => 'text-light bg-primary hover:bg-light hover:text-primary',
      'default' => 'text-primary bg-background hover:bg-primary hover:text-light',
  };
@endphp

<div class="relative">
  <div
    {{ $attributes->merge([
        'class' => "peer p-2.5 rounded-full aspect-square transition-colors duration-200 {$cvariant}",
    ]) }}>
    <i data-lucide={{ $icon }} class="size-5"></i>
  </div>

  <span
    class="absolute z-10 px-2 py-1 text-sm text-center transition-all ease-out -translate-x-1/2 rounded-lg opacity-0 text-light bg-primary -bottom-9 left-1/2 whitespace-nowrap peer-hover:opacity-100 peer-focus:opacity-100"
    role="tooltip">
    {{ $label }}
  </span>
</div>
