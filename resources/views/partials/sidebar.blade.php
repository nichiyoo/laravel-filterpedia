@php
  $menus = [
      'Profil' => [
          'route' => 'profile.index',
          'icon' => 'user',
          'label' => 'Profil',
      ],
      'Pesanan' => [
          'route' => 'orders.index',
          'icon' => 'box',
          'label' => 'Pesanan',
      ],
      'Pengaturan' => [
          'route' => 'profile.setting',
          'icon' => 'settings',
          'label' => 'Pengaturan',
      ],
  ];
@endphp

<ul class="flex flex-col space-y-6">
  @foreach ($menus as $menu)
    <li class="w-full">
      <a href="{{ route($menu['route']) }}" class="flex items-center space-x-2">
        <i data-lucide="{{ $menu['icon'] }}" class="text-primary size-5"></i>
        <span class="font-medium text-text">{{ $menu['label'] }}</span>
      </a>
    </li>
  @endforeach

  <li class="w-full">
    <form action="{{ route('auth.logout') }}" method="POST">
      @csrf
      <button type="submit" class="flex items-center p-0 space-x-2">
        <i data-lucide="log-out" class="text-primary size-5"></i>
        <span class="font-medium text-text">Keluar</span>
      </button>
    </form>
  </li>
</ul>
