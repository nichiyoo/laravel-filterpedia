<x-app-layout>
  <section class="flex flex-col space-y-8">
    <div>
      <h1 class="mb-2 text-6xl font-bold text-primary">
        Selamat datang di <span class="text-accent">Filterpedia</span>.
      </h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta voluptate beatae nulla blanditiis ipsa
        repellendus iure dolores quisquam tempora illo.
      </p>
    </div>

    <div>
      @include('partials.banner')
    </div>

    <div>
      @include('partials.categories', [
          'title' => 'Kategori Produk',
          'categories' => $categories,
      ])
    </div>

    <div>
      @include('partials.products', [
          'title' => 'Produk Populer',
          'products' => $populars->data,
          'count' => 4,
      ])
    </div>

    <div>
      @include('partials.brands')
    </div>

    <div>
      @include('partials.products', [
          'title' => 'Produk Terbaru',
          'products' => $products->data,
          'count' => 4,
      ])
    </div>

    <a href={{ route('products.index') }}>
      <x-button>
        Lihat Semua Produk
      </x-button>
    </a>
  </section>
</x-app-layout>
