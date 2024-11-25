<x-app-layout>
  <section class="flex flex-col space-y-8">
    <div>
      <h1 class="mb-2 text-5xl font-bold text-primary">
        Konfirmasi checkout.
      </h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta voluptate beatae nulla blanditiis ipsa
        repellendus iure dolores quisquam tempora illo.
      </p>
    </div>

    <div class="grid items-start gap-8 lg:grid-cols-5">
      <div class="p-6 border border-border rounded-xl lg:col-span-3">
        <form method="POST" action="{{ route('profile.update') }}" class="grid gap-6 lg:grid-cols-2">
          @csrf

          <div>
            <x-label for="name">Nama</x-label>
            <x-input name="name" id="name" value="{{ $user->name }}" />
            <x-error field="name" />
          </div>

          <div>
            <x-label for="phone">Telepon</x-label>
            <x-input name="phone" id="phone" value="{{ $user->user_detail->telepon }}" />
            <x-error field="phone" />
          </div>

          <div class="flex flex-col space-y-1 col-span-full">
            <x-label for="address">Alamat</x-label>
            <x-textarea name="address" id="address">{{ $user->user_detail->alamat }}</x-textarea>
            <x-error field="address" />
          </div>

          <div>
            <x-label for="province">Provinsi</x-label>
            <x-select name="province" id="province">
              @foreach ($provinces as $province)
                <option value="{{ $province->id }}"
                  {{ $user->user_detail->provinsi_id == $province->id ? 'selected' : '' }}>
                  {{ $province->provinsi_name }}
                </option>
              @endforeach
            </x-select>
            <x-error field="province" />
          </div>

          <div>
            <x-label for="zipcode">Kode Pos</x-label>
            <x-input name="zipcode" id="zipcode" value="{{ $user->user_detail->kode_pos }}" />
            <x-error field="zipcode" />
          </div>

          <div class="flex items-center space-x-2 col-span-full">
            <x-button type="submit">Simpan</x-button>
            <x-button type="reset" variant="ghost">Reset Form</x-button>
          </div>
        </form>
      </div>

      <div class="lg:col-span-2">
        <div class="flex flex-col border border-border rounded-t-xl">
          @php
            $temp = $product->discount ? $product->discount->discount : 0;
            $discount = ($product->product_price * (100 - $temp)) / 100;
          @endphp

          <div class="grid p-6 border-b last:border-none border-border">
            <div class="flex items-start gap-4">
              <a href="{{ route('products.show', $product->slug) }}" class="flex-none">
                <img src="{{ $product->imageurl ?? asset('placeholder.jpg') }}" alt="{{ $product->product_name }}"
                  class="object-cover size-20 rounded-xl aspect-square">
              </a>

              <div class="flex flex-col w-full mb-2">
                <div class="flex items-center justify-between w-full">
                  <span class="font-medium text-text">{{ $product->product_name }}</span>
                  <span class="font-medium text-primary">
                    Rp {{ number_format($product->product_price, 2) }}
                  </span>
                </div>
                <span>Rp {{ number_format($discount, 2) }}</span>
                <span>1 Unit</span>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col p-6 border-x border-border">
          <div class="flex items-center justify-between">
            <x-label>Biaya Pengiriman</x-label>
            <span class="font-medium text-primary">Rp {{ number_format($delivery, 2) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <x-label>Pajak PPN</x-label>
            <span class="font-medium text-primary">Rp {{ number_format($delivery * 0.1, 2) }}</span>
          </div>
          <div class="flex items-center justify-between">
            <x-label>Total</x-label>
            <span class="font-medium text-primary">Rp {{ number_format($total + $delivery, 2) }}</span>
          </div>
        </div>

        <div class="flex flex-col p-6 border border-border rounded-b-xl">
          <form method="POST" action="{{ route('cart.single') }}" class="grid gap-6">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
              <x-label for="method">Pilih Metode Pembayaran</x-label>
              <x-select name="method" id="method">
                @foreach ($methods as $method)
                  <option value="{{ $method->id }}">{{ $method->nama_bank }}</option>
                @endforeach
              </x-select>
              <x-error field="method" />
            </div>

            <div class="w-full">
              <x-button type="submit">Buat Transaksi</x-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-app-layout>
