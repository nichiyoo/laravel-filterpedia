<x-app-layout>
  <section class="flex flex-col space-y-8">
    <div>
      <h1 class="mb-2 text-5xl font-bold text-primary">
        Produk {{ $category->category_name }}.
      </h1>

      <p>
        {{ $category->category_description }}
      </p>
    </div>

    @if (count($products) > 0)
      <div>
        @include('partials.products', [
            'title' => 'Produk',
            'products' => $products,
        ])
      </div>
    @else
      <div class="flex flex-col items-center justify-center space-y-2 text-center h-96 bg-border/50 rounded-xl">
        <i data-lucide="triangle-alert" class="size-5 text-accent"></i>
        <p>
          Tidak ada produk yang ditemukan
        </p>
        <a href={{ route('landing') }}>
          <x-button>
            Kembali ke Beranda
          </x-button>
        </a>
      </div>
    @endif
  </section>


</x-app-layout>
