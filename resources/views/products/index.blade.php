<x-app-layout>
  <section class="flex flex-col space-y-8">
    <div>
      <h1 class="mb-2 text-5xl font-bold text-primary">
        Produk Filterpedia.
      </h1>

      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta voluptate beatae nulla blanditiis ipsa
        repellendus iure dolores quisquam tempora illo.
      </p>
    </div>

    <div>
      @include('partials.categories', [
          'title' => 'Kategori Produk',
          'categories' => $categories,
      ])
    </div>

    <div>
      @include('partials.products', [
          'title' => 'Semua Produk',
          'products' => $products->data,
      ])
    </div>
  </section>
</x-app-layout>
