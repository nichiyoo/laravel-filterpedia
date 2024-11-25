<h2 class="mb-4 text-xl font-semibold text-text">
  {{ $title }}
</h2>

<div class="grid grid-cols-2 gap-4 lg:gap-6 lg:grid-cols-4">
  @foreach (array_slice($products, 0, $count ?? count($products)) as $product)
    <a href={{ route('products.show', $product->slug) }} class="border rounded-xl border-border bg-card">
      <img src="{{ $product->imageurl ?? asset('placeholder.jpg') }}" alt="{{ $product->product_name }}"
        class="object-cover aspect-frame bg-border/50 rounded-t-xl">

      <div class="flex flex-col p-4 space-y-2 lg:px-6">
        <h5 class="font-medium text-text">{{ $product->product_name }}</h5>
        <p class="hidden md:line-clamp-2">
          {{ $product->product_description }}
        </p>

        <div class="flex items-center justify-between text-sm font-medium md:text-base">
          <span class="text-green-600 ">Rp {{ number_format($product->product_price, 2) }}</span>
          <div class="flex items-center space-x-1">
            <div class="relative">
              <i data-lucide="heart" class="text-red-600 cursor-pointer peer size-4"></i>
              <span
                class="absolute z-10 px-2 py-1 text-sm text-center transition-all ease-out -translate-x-1/2 rounded-lg opacity-0 text-background bg-primary -bottom-9 left-1/2 whitespace-nowrap peer-hover:opacity-100 peer-focus:opacity-100"
                role="tooltip">
                Disukai
              </span>
            </div>
            <span>{{ $product->likedCount }}</span>
          </div>
        </div>
      </div>
    </a>
  @endforeach
</div>
