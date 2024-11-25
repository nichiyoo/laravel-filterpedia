@php
  $menus = [
      'home' => [
          'icon' => 'home',
          'label' => 'Beranda',
          'route' => 'landing',
      ],
      'products' => [
          'icon' => 'layout-grid',
          'label' => 'Produk',
          'route' => 'products.index',
      ],
      'cart' => [
          'icon' => 'shopping-bag',
          'label' => 'Keranjang',
          'route' => 'cart.index',
      ],
      'profile' => [
          'icon' => 'user',
          'label' => 'Profil',
          'route' => 'profile.index',
      ],
  ];
@endphp

<div class="fixed bottom-0 z-50 w-full md:hidden">
  <div class="border-t bg-background border-border">
    <div class="grid items-center grid-cols-4">
      @foreach ($menus as $key => $value)
        <a href="{{ route($value['route']) }}"
          class="py-4 flex flex-col items-center space-y-1 cursor-pointer group hover:text-accent @if (Route::is($value['route'])) text-primary @endif">
          <i data-lucide="{{ $value['icon'] }}" class="size-5"></i>
          <span class="text-sm">{{ $value['label'] }}</span>
        </a>
      @endforeach
    </div>
  </div>
</div>
