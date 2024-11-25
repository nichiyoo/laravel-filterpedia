<x-profile-layout>
  <section class="flex flex-col space-y-6">
    <div>
      <h2 class="text-xl font-semibold text-primary">
        {{ __('Detail Pesanan') }}
      </h2>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, facilis!
      </p>
    </div>

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

      <div class="p-6 border-b border-border">
        <div class="grid lg:grid-cols-2">
          <div class="flex flex-col gap-2">
            <div>
              <label class="block text-sm">Nama Bank</label>
              <span class="text-text">{{ $order->payment_method->nama_bank }}</span>
            </div>
            <div>
              <label class="block text-sm">Nama Rekening</label>
              <span class="text-text">{{ $order->payment_method->atas_nama_rekening }}</span>
            </div>
            <div>
              <label class="block text-sm">Nomor Rekening</label>
              <span class="text-text">{{ $order->payment_method->nomor_rekening }}</span>
            </div>
          </div>

          <div class="flex flex-col gap-2">
            <div>
              <label class="block text-sm">Total Transkasi</label>
              <span class="text-text">Rp {{ number_format($order->total_price, 2) }}</span>
            </div>
            <div>
              <label class="block text-sm">Pajak PPN</label>
              <span class="text-text">Rp {{ number_format($order->pajak_ppn, 2) }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="border-b border-border">
        @foreach ($order->transaction_detail as $item)
          <div class="grid p-6 border-b last:border-none border-border">
            <div class="flex items-start gap-4">
              <a href="{{ route('products.show', $item->products->slug) }}" class="flex-none">
                <img src="{{ $item->products->imageurl ?? asset('placeholder.jpg') }}"
                  alt="{{ $item->products->product_name }}" class="object-cover size-20 rounded-xl aspect-square">
              </a>

              <div class="flex flex-col w-full mb-2">
                <div class="flex items-center justify-between w-full">
                  <span class="font-medium text-text">{{ $item->products->product_name }}</span>
                  <span class="font-medium text-primary">
                    Rp {{ number_format($item->total_price, 2) }}
                  </span>
                </div>
                <span>{{ $item->qty }} Unit</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      @if ($order->status == 0)
        <div class="p-6 border-b border-border">
          <form action="{{ route('orders.payment') }}" method="POST" enctype="multipart/form-data" class="grid gap-6">
            @csrf

            <input type="hidden" name="transaction_id" value="{{ $order->id }}">

            <div>
              <x-label for="receipt">Bukti Pembayaran</x-label>
              <x-input type="file" name="receipt" id="receipt" accept="image/*" class="file:hidden" />
              <x-error field="receipt" />
            </div>

            <div>
              <x-button type="submit" variant="primary">
                {{ __('Upload Bukti') }}
              </x-button>
            </div>
          </form>

        </div>

        <div class="p-6">
          <form action="{{ route('orders.cancel') }}" method="POST">
            @csrf
            <input type="hidden" name="transaction_id" value="{{ $order->id }}">

            <div class="flex items-center gap-2">
              <x-button type="submit" variant="danger" class="peer">
                {{ __('Batalkan Pesanan') }}
              </x-button>
              <p
                class="text-sm text-red-600 transition-opacity duration-200 ease-out opacity-0 peer-hover:opacity-100 peer-focus:opacity-100">
                Jika Anda memilih Batalkan Pesanan, dan Anda tidak akan dapat melakukan pembayaran
                lagi.
              </p>
            </div>
          </form>
        </div>
      @endif
    </div>
  </section>
</x-profile-layout>
