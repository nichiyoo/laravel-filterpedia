<x-profile-layout>
  <div class="mb-4">
    <h2 class="text-xl font-semibold text-primary">
      {{ __('Pengaturan') }}
    </h2>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, facilis!
    </p>
  </div>

  <form method="POST" action="{{ route('profile.password') }}" class="grid gap-6 lg:grid-cols-2">
    @csrf

    <div>
      <x-label for="old_password">Password Lama</x-label>
      <x-input name="old_password" id="old_password" type="password" />
      <x-error field="old_password" />
    </div>

    <div>
      <x-label for="password">Password Baru</x-label>
      <x-input name="password" id="password" type="password" />
      <x-error field="password" />
    </div>

    <div>
      <x-label for="confirmation">Konfirmasi Password Baru</x-label>
      <x-input name="confirmation" id="confirmation" type="password" />
      <x-error field="confirmation" />
    </div>

    <div class="flex items-center space-x-2 col-span-full">
      <x-button type="submit">Simpan</x-button>
      <x-button type="reset" variant="ghost">Reset Form</x-button>
    </div>
  </form>
</x-profile-layout>
