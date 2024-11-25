@php
  $types = [
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
  ];
@endphp

@php
  $selected = request()->get('type') ?? 'all';
@endphp

<div class="grid grid-cols-3 md:hidden">
  @foreach ($types as $key => $value)
    <a href="{{ route('orders.index', ['type' => $key]) }}" class="flex flex-col items-center space-y-2">
      <div
        class="flex items-center justify-center rounded-full size-12 {{ $selected == $key ? 'bg-primary text-light' : 'bg-border/50 text-primary' }}">
        <i data-lucide="{{ $value['icon'] }}" class="size-6"></i>
      </div>
      <span class="font-medium text-center text-balance text-text">{{ $value['label'] }}</span>
    </a>
  @endforeach
</div>
