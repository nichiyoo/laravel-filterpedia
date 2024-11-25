<footer class="hidden bg-dark md:block text-light/60">
  <div class="container grid grid-cols-2 py-8 max-w-7xl">
    <div class="group">
      <h1 class="text-lg font-medium text-light">{{ env('APP_NAME', 'Laravel') }}</h1>
      <p>Water and Waste Water Treatment Engineering</p>
    </div>
    <div class="group text-end">
      <h1 class="text-lg font-medium text-light">Autorized Product</h1>
      <p>Water and Waste Water Treatment Engineering</p>
    </div>
  </div>

  <div class="w-full border-b border-border opacity-10"></div>

  <div class="container grid gap-6 py-8 lg:grid-cols-4 max-w-7xl">

    <div class="group">
      <h5 class="mb-2 font-medium text-light">Service</h5>
      <ul class="flex flex-col list-none">
        <li><a href="#">021-59582271</a></li>
        <li><a href="{{ route('check') }}">Cek Order Status</a></li>
        <li><a href="#">Change location</a></li>
        <li><a href="#">FAQ's</a></li>
      </ul>
    </div>

    <div class="group">
      <h5 class="mb-2 font-medium text-light">Policies</h5>
      <ul class="flex flex-col list-none">
        <li><a href="#">Term of use</a></li>
        <li><a href="{{ route('privacy') }}">Privacy policy</a></li>
        <li><a href="#">Refund policy</a></li>
        <li><a href="#">Billing system</a></li>
      </ul>
    </div>

    <div class="group">
      <h5 class="mb-2 font-medium text-light">About Shopper</h5>
      <ul class="flex flex-col list-none">
        <li><a href="#">Company Information</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Affiliate Program</a></li>
      </ul>
    </div>

    <div class="group">
      <h5 class="mb-2 font-medium text-light">Dapatkan Info Terbaru</h5>
      <form action="{{ route('subscribe') }}" method="POST">
        @csrf
        <x-input type="email" placeholder="Masukkan Email Anda" class="mb-2 bg-light" />
        <x-button type="submit" class="w-full">
          Mulai Berlangganan
        </x-button>
      </form>
    </div>
  </div>

  <div class="w-full border-b border-border opacity-10"></div>

  <div class="container py-5 text-center max-w-7xl">
    <span>&copy; {{ date('Y') }} {{ env('APP_NAME', 'Laravel') }}. All rights reserved.</span>
  </div>
</footer>
