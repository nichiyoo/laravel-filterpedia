<x-profile-layout>
  <section class="flex flex-col space-y-6">
    <div>
      <h2 class="text-xl font-semibold text-primary">
        {{ __('Pesanan') }}
      </h2>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, facilis!
      </p>
    </div>

    @include('partials.types', [
        'selected' => $selected,
    ])

    <div class="flex flex-col space-y-6">
      @forelse ($orders as $order)
        @php
          $color = match ($order->status) {
              0 => ' font-medium bg-amber-600 text-white',
              6 => ' font-medium bg-red-600 text-white',
          };
        @endphp

        <div class="border rounded-xl bg-background border-border">
          <div class="p-6 border-b border-border">
            <div class="grid gap-2 lg:grid-cols-2">
              <div>
                <label class="block text-sm">Kode Transaksi</label>
                <span class="text-text">{{ $order->transaction_code }}</span>
              </div>
              <div>
                <label class="block text-sm">Tanggal Transaksi</label>
                <span class="text-text">{{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y') }}</span>
              </div>
              <div>
                <label class="block text-sm">Jumlah Produk</label>
                <span class="text-text">{{ $order->total_item }} Unit</span>
              </div>
              <div>
                <label class="block text-sm">Total</label>
                <span class="font-medium text-green-600">{{ number_format($order->sub_total_price, 2) }}</span>
              </div>
              <div>
                <label class="block text-sm">Status</label>
                <span class="text-sm px-2 py-1 rounded-md {{ $color }}">{{ $order->status_transaksi }}</span>
              </div>
            </div>
          </div>

          <div class="px-6 py-4">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('orders.show', $order->id) }}">
                <x-button>
                  {{ $order->status == 0 ? 'Pembayaran' : 'Detail Order' }}
                </x-button>
              </a>

              @if ($order->status != 6)
                <form action="{{ route('orders.cancel') }}" method="POST">
                  @csrf
                  <input type="hidden" name="transaction_id" value="{{ $order->id }}">
                  <x-button type="submit" variant="danger">
                    {{ __('Batalkan') }}
                  </x-button>
                </form>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="p-6 border rounded-xl bg-background border-border">
          <div class="flex flex-col items-center justify-center space-y-2 text-center h-96">
            <i data-lucide="triangle-alert" class="size-5 text-accent"></i>
            <p>
              Tidak ada pesanan yang ditemukan
            </p>
            <a href={{ route('landing') }}>
              <x-button>
                Kembali ke Beranda
              </x-button>
            </a>
          </div>
        </div>
      @endforelse
    </div>
  </section>
</x-profile-layout>
