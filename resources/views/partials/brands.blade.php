<h2 class="mb-4 text-xl font-semibold text-text">
  {{ __('Brands') }}
</h2>

<div class="overflow-hidden brands">
  <div class="flex items-center">
    @for ($i = 0; $i < 10; $i++)
      <div class="flex-none p-4 group basis-1/3 lg:basis-1/6 hover:bg-border/50 rounded-xl">
        <img src="{{ asset('brands/suez.png') }}" alt="Suez" class="object-cover mx-auto">
      </div>
    @endfor
  </div>
</div>
