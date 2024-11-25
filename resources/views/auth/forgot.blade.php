<x-guest-layout>
  <div class="flex flex-col space-y-8">
    <div class="flex flex-col space-y-2">
      <h1 class="text-5xl font-bold text-primary">
        Masukan email yang terdaftar
      </h1>
      <p>
        Masuk dengan email yang terdaftar untuk mengakses akun kamu.
      </p>
    </div>

    <form action="{{ route('auth.recovery') }}" method="POST" class="flex flex-col space-y-4">
      @csrf
      <div>
        <x-label for="email">Email</x-label>
        <x-input name="email" id="email" placeholder="Masukkan Email Anda" />
        <x-error field="email" />
      </div>

      <div class="flex flex-col items-center gap-4">
        <x-button type="submit" class="w-full">Kirim Link Verifikasi</x-button>
        <p class="text-sm text-center text-text">
          Setelah mendapatkan kode OTP, Anda dapat mengakses <a href="{{ route('auth.change') }}"
            class="text-accent">halaman reset password</a> untuk mengatur ulang password Anda.
        </p>
      </div>
    </form>
  </div>
</x-guest-layout>
