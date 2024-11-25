<x-app-layout>
  <section class="flex flex-col space-y-8">
    <div>
      <h1 class="mb-2 text-5xl font-bold text-primary">
        Keranjang anda.
      </h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta voluptate beatae nulla blanditiis ipsa
        repellendus iure dolores quisquam tempora illo.
      </p>
    </div>

    <div class="hidden border border-border rounded-xl xl:block">
      <table class="w-full table-auto">
        <thead>
          <tr class="font-medium border-b border-border text-text">
            <th class="px-4 py-2 text-start">No</th>
            <th class="px-4 py-2 text-start">Produk</th>
            <th class="px-4 py-2 text-start">Harga</th>
            <th class="px-4 py-2 text-start">Jumlah</th>
            <th class="px-4 py-2 text-start">Total</th>
            <th class="px-4 py-2 text-start">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($cart as $item)
            @php
              $product = $item->products[0];
              $temp = $product->discount ? $product->discount->discount : 0;
              $discount = ($product->product_price * (100 - $temp)) / 100;
            @endphp
            <tr class="border-b last:border-none border-border">
              <td class="px-4 py-2">{{ $loop->iteration }}</td>
              <td class="px-4 py-2">
                <a href="{{ route('products.show', $product->slug) }}" class="flex items-center gap-4">
                  <img src="{{ $product->imageurl ?? asset('placeholder.jpg') }}" alt="{{ $product->product_name }}"
                    class="flex-none object-cover size-20 rounded-xl aspect-square">
                  <span class="font-medium text-text">{{ $product->product_name }}</span>
                </a>
              </td>
              <td class="px-4 py-2">
                <div>
                  @if ($product->discount)
                    <span class="line-through">
                      Rp {{ number_format($product->product_price, 2) }}
                    </span>
                    <span class="font-medium text-primary">
                      Rp {{ number_format($discount, 2) }}
                    </span>
                  @else
                    <span class="font-medium text-primary">
                      Rp {{ number_format($product->product_price, 2) }}
                    </span>
                  @endif
                </div>
              </td>
              <td class="px-4 py-2">{{ $item->qty }}</td>
              <td class="px-4 py-2">
                <span class="font-medium text-primary">
                  Rp {{ number_format($item->total_price, 2) }}
                </span>
              </td>
              <td class="px-4 py-2">
                <div class="flex items-center gap-2">
                  @include('partials.action', [
                      'item' => $item,
                  ])
              </td>
            </tr>
          @empty
            <tr class="border-b border-border">
              <td class="px-4 py-20 text-center" colspan="6">
                <div class="flex flex-col items-center justify-center space-y-2 text-center">
                  <i data-lucide="triangle-alert" class="size-5 text-accent"></i>
                  <p>
                    Tidak ada produk yang ditemukan
                  </p>
                  <a href={{ route('products.index') }}>
                    <x-button>
                      Mulai Belanja
                    </x-button>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="border xl:hidden border-border rounded-xl">
      <div class="flex flex-col">
        @forelse ($cart as $item)
          @php
            $product = $item->products[0];
            $temp = $product->discount ? $product->discount->discount : 0;
            $discount = ($product->product_price * (100 - $temp)) / 100;
          @endphp

          <div class="grid p-4 border-b last:border-none border-border">
            <div class="flex items-start gap-4">
              <a href="{{ route('products.show', $product->slug) }}" class="flex-none">
                <img src="{{ $product->imageurl ?? asset('placeholder.jpg') }}" alt="{{ $product->product_name }}"
                  class="object-cover size-20 rounded-xl aspect-square">
              </a>

              <div class="flex flex-col w-full mb-2">
                <div class="flex items-center justify-between w-full">
                  <span class="font-medium text-text">{{ $product->product_name }}</span>
                  <span class="font-medium text-primary">
                    Rp {{ number_format($item->total_price, 2) }}
                  </span>
                </div>
                <span>Rp {{ number_format($discount, 2) }}</span>
                <span>{{ $item->qty }} Unit</span>
              </div>
            </div>

            <div class="flex justify-end gap-2">
              @include('partials.action', [
                  'item' => $item,
              ])
            </div>
          </div>
        @empty
          <div class="flex flex-col items-center justify-center py-20 space-y-2 text-center">
            <i data-lucide="triangle-alert" class="size-5 text-accent"></i>
            <p>
              Tidak ada produk yang ditemukan
            </p>
            <a href={{ route('products.index') }}>
              <x-button>
                Mulai Belanja
              </x-button>
            </a>
          </div>
        @endforelse
      </div>
    </div>

    <div class="flex items-center">
      <a href={{ route('cart.checkout') }}>
        <x-button>
          Checkout
        </x-button>
      </a>
      <span class="ml-auto font-medium text-primary">Total Rp {{ number_format($total, 2) }}</span>
    </div>
  </section>
</x-app-layout>
