@php
  $types = [
      'all' => [
          'label' => 'Semua Pesanan',
          'icon' => 'box',
      ],
      'pending' => [
          'label' => 'Menunggu Pembayaran',
          'icon' => 'timer',
      ],
      'ongoing' => [
          'label' => 'Sedang Dikirim',
          'icon' => 'car',
      ],
      'delivered' => [
          'label' => 'Berhasil Dikirim',
          'icon' => 'shopping-bag',
      ],
      'cancelled' => [
          'label' => 'Dibatalkan',
          'icon' => 'x',
      ],
  ];
@endphp

@php
  $selected = request()->get('type') ?? 'all';
@endphp

<div class="flex-wrap items-center hidden gap-2 lg:flex text-text">
  @foreach ($types as $key => $value)
    <a href="{{ route('orders.index', ['type' => $key]) }}"
      class="border flex items-center gap-2 p-2 rounded-xl {{ $selected == $key ? 'bg-primary text-light border-transparent' : 'border-border bg-background' }}">
      <i data-lucide="{{ $value['icon'] }}" class="flex-none size-5"></i>
      <span class="text-sm text-nowrap">{{ $value['label'] }}</span>
    </a>
  @endforeach
</div>
