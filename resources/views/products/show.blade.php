<x-app-layout>
  <section class="flex flex-col space-y-8">
    <nav>
      <ul class="flex items-center gap-2">
        <li><a href="{{ route('landing') }}" class="hover:text-accent">Home</a></li>
        <li><span><i data-lucide="chevron-right" class="size-4"></i></span></li>
        <li><a href="{{ route('products.index') }}" class="hover:text-accent">Products</a></li>
        <li><span><i data-lucide="chevron-right" class="size-4"></i></span></li>
        <li><span class="text-accent">{{ $product->product_name }}</span></li>
      </ul>
    </nav>

    <div>
      <h1 class="mb-2 text-5xl font-bold text-primary">
        {{ $product->product_name }}.
      </h1>
      <p>
        {{ $product->product_description }}
      </p>
    </div>

    <div class="grid items-start gap-8 md:grid-cols-2">
      <div class="flex flex-col space-y-2">
        <div class="overflow-hidden viewports rounded-xl">
          <div class="flex items-center">
            <div class="flex-none w-full basis-full aspect-square">
              <img src="{{ $product->imageurl }}" alt="{{ $product->product_name }}" class="object-cover size-full">
            </div>
            @foreach ($thumbnails as $thumbnail)
              <div class="flex-none w-full basis-full aspect-square">
                <img src="{{ $thumbnail->imageurl }}" alt="{{ $product->product_name }}" class="object-cover size-full">
              </div>
            @endforeach
          </div>
        </div>

        <div class="overflow-hidden thumbnails">
          <div class="flex items-center gap-2">
            <div class="w-full overflow-hidden border cursor-pointer thumbs basis-1/5 aspect-frame rounded-xl">
              <img src="{{ $product->imageurl }}" alt="{{ $product->product_name }}"
                class="object-cover pointer-events-none size-full">
            </div>
            @foreach ($thumbnails as $thumbnail)
              <div class="w-full overflow-hidden border cursor-pointer thumbs basis-1/5 aspect-frame rounded-xl">
                <img src="{{ $thumbnail->imageurl }}" alt="{{ $product->product_name }}"
                  class="object-cover pointer-events-none size-full">
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div>
        <div class="flex flex-col p-8 space-y-4 border border-border rounded-t-xl">
          <div>
            <h2 class="text-xl font-medium text-text">
              {{ $product->product_name }}
            </h2>
            <p>
              {{ $product->product_description }}
            </p>
          </div>

          <div>
            <span class="text-xl font-bold text-green-600">
              Rp {{ number_format($product->harga_setelah_discount ?? $product->product_price, 2) }}
            </span>
            <span class="text-sm">Harga sudah termasuk PPN</span>
          </div>

          @if ($product->discount)
            <div class="flex items-center gap-2">
              <span class="block px-2 py-1 text-sm font-bold bg-red-600 rounded-lg text-background">
                {{ $product->discount->discount }}% Off
              </span>
              <span class="text-sm font-medium line-through">
                Rp {{ number_format($product->product_price, 2) }}
              </span>
            </div>
          @endif

          <div class="flex flex-col items-center w-full gap-2 lg:flex-row">
            <a href="{{ route('cart.direct', $product->slug) }}" class="w-full lg:w-auto">
              <x-button class="w-full lg:w-auto">
                {{ __('Beli Langsung') }}
              </x-button>
            </a>

            <form action="{{ route('cart.add') }}" method="POST" class="w-full lg:w-auto">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <x-button type="submit" variant="ghost" class="w-full">
                {{ __('Tambahkan ke Keranjang') }}
              </x-button>
            </form>
          </div>
        </div>

        <div class="px-8 py-4 mb-8 border border-t-0 border-border rounded-b-xl">
          <div class="flex items-center gap-4">
            <form action="{{ route('products.like') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <button type="submit" class="flex items-center gap-2">
                <i data-lucide="heart" class="text-red-600 size-5"></i>
                <span class="text-sm">{{ $product->likedCount . __(' Disukai') }}</span>
              </button>
            </form>

            <a href="{{ $chat }}" class="flex items-center gap-2">
              <i data-lucide="message-circle" class="size-5 text-accent"></i>
              <span class="text-sm">{{ __('Chat') }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div>
      <h2 class="mb-4 text-xl font-medium text-text">
        {{ __('Informasi Produk') }}
      </h2>
      <p>
        {{ $product->product_description }}
      </p>
    </div>

    <div>
      @include('partials.products', [
          'products' => $similars,
          'title' => 'Produk Serupa',
      ])
    </div>
  </section>
</x-app-layout>
