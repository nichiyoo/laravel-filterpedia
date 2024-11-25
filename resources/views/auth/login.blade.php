<x-guest-layout>
  <div class="flex flex-col space-y-8">
    <div class="flex flex-col space-y-2">
      <h1 class="text-5xl font-bold text-primary">
        Belanja kebutuhan Air, menjadi lebih mudah
      </h1>
      <p>
        Masuk dengan email dan kata sandi kamu untuk mengakses akun kamu.
      </p>
    </div>

    <form action="{{ route('auth.signin') }}" method="POST" class="flex flex-col space-y-4">
      @csrf

      <div>
        <x-label for="email">Email</x-label>
        <x-input name="email" id="email" placeholder="Masukkan Email Anda" />
        <x-error field="email" />
      </div>

      <div>
        <x-label for="password">Kata Sandi</x-label>
        <x-input name="password" id="password" placeholder="Masukkan Kata Sandi Anda" type="password" />
        <x-error field="password" />
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <input type="checkbox" name="remember" id="remember"
            class="w-4 h-4 rounded border-border text-accent focus:ring-accent focus:ring-opacity-50" />
          <x-label for="remember">Ingat saya</x-label>
        </div>
        <a href="{{ route('auth.forgot') }}" class="text-sm hover:text-primary">
          Lupa Kata Sandi?
        </a>
      </div>

      <div class="flex flex-col items-center gap-4">
        <x-button type="submit" class="w-full">Masuk</x-button>

        <a href="{{ route('auth.register') }}" class="block w-full">
          <x-button variant="secondary" class="w-full">Daftar</x-button>
        </a>
      </div>
    </form>
  </div>
</x-guest-layout>
