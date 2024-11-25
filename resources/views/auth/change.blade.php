<x-guest-layout>
  <div class="flex flex-col space-y-8">
    <div class="flex flex-col space-y-2">
      <h1 class="text-5xl font-bold text-primary">
        Reset Password
      </h1>
      <p>
        Masuk dengan OTP yang telah dikirim ke email Anda untuk mengatur ulang password Anda.
      </p>
    </div>

    <form action="{{ route('auth.reset') }}" method="POST" class="flex flex-col space-y-4">
      @csrf

      <div>
        <x-label for="email">Email</x-label>
        <x-input name="email" id="email" placeholder="Masukkan Email Anda" />
        <x-error field="email" />
      </div>

      <div>
        <x-label for="otp">Kode OTP</x-label>
        <x-input name="otp" id="otp" placeholder="Masukkan Kode OTP Anda" />
        <x-error field="otp" />
      </div>

      <div>
        <x-label for="password">Password Baru</x-label>
        <x-input name="password" id="password" type="password" placeholder="Masukkan Password Baru Anda" />
        <x-error field="password" />
      </div>

      <div>
        <x-label for="confirmation">Konfirmasi Password Baru</x-label>
        <x-input name="confirmation" id="confirmation" type="password" placeholder="Konfirmasi Password Baru Anda" />
        <x-error field="confirmation" />
      </div>

      <div class="flex flex-col items-center gap-4">
        <x-button type="submit" class="w-full">Kirim Link Verifikasi</x-button>
        <p class="text-sm text-center text-text">
          Jika Anda tidak mendapatkan kode OTP, Anda dapat mengirim ulang email ke <a href="{{ route('auth.forgot') }}"
            class="text-accent">halaman ulang email</a>.
        </p>
      </div>
    </form>
  </div>
</x-guest-layout>
