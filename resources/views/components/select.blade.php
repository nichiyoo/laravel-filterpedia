@props(['disabled' => false])

<select
  {{ $attributes->merge(['class' => 'form-select w-full p-2.5 text-sm border rounded-lg text-text bg-border/50 border-border focus:border-accent focus:ring-accent disabled:bg-border disabled:border-transparent']) }}
  {{ $disabled ? 'disabled' : '' }}>
  {{ $slot }}
</select>
