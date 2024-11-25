<label {{ $attributes->merge([
    'class' => 'text-sm font-medium text-text block mb-1',
]) }}>
  {{ $slot }}
</label>
