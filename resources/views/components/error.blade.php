@props(['field'])

@if ($errors->has($field))
  <div class="flex items-center gap-2 mt-1 text-sm text-red-600">
    <i data-lucide="triangle-alert" class="size-4"></i>
    <span>{{ $errors->first($field) }}</span>
  </div>
@endif
