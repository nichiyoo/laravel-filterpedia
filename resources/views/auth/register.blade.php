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

    <form action="{{ route('auth.signup') }}" method="POST" class="flex flex-col space-y-4" enctype="multipart/form-data">
      @csrf

      <div>
        <x-label for="name">Nama Lengkap</x-label>
        <x-input name="name" id="name" placeholder="Masukkan Nama Lengkap Anda" />
        <x-error field="name" />
      </div>

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

      <div>
        <x-label for="confirmation">Konfirmasi Kata Sandi</x-label>
        <x-input name="confirmation" id="confirmation" placeholder="Konfirmasi Kata Sandi Anda" type="password" />
        <x-error field="confirmation" />
      </div>

      <div>
        <x-label for="bussiness">Belanja untuk kebutuhan perusahaan</x-label>

        <div class="flex items-center gap-2">
          <input type="radio" name="bussiness" id="bussiness" value="1"
            class="w-4 h-4 border-border text-accent focus:ring-accent focus:ring-opacity-50" />
          <x-label for="bussiness">Ya</x-label>
        </div>

        <div class="flex items-center gap-2">
          <input type="radio" name="bussiness" id="personal" value="0" checked
            class="w-4 h-4 border-border text-accent focus:ring-accent focus:ring-opacity-50" />
          <x-label for="bussiness">Tidak</x-label>
        </div>
      </div>

      <div class="hidden bussiness">
        <x-label for="company">Nama Perusahaan</x-label>
        <x-input name="company" id="company" placeholder="Masukkan Nama Perusahaan Anda" />
        <x-error field="company" />
      </div>

      <div class="hidden bussiness">
        <x-label for="npwp">Nomor NPWP</x-label>
        <x-input type="number" name="npwp" id="npwp" placeholder="Masukkan Nomor NPWP Anda" />
        <x-error field="npwp" />
      </div>

      <div class="hidden bussiness">
        <x-label for="image">Foto NPWP</x-label>
        <img id="preview" src="{{ asset('placeholder.jpg') }}" alt="preview"
          class="object-cover w-full border border-border rounded-xl aspect-video bg-border/50">
        <x-input name="image" id="image" type="file" accept="image/*" class="file:hidden" />
        <x-error field="image" />
      </div>

      <div class="flex flex-col items-center gap-4">
        <x-button type="submit" class="w-full">Daftar</x-button>
        <a href="{{ route('auth.login') }}" class="block w-full">
          <x-button variant="secondary" class="w-full">Masuk</x-button>
        </a>
      </div>
    </form>
  </div>

  @push('scripts')
    <script>
      const image = document.querySelector('#image');
      const preview = document.querySelector('#preview');

      image.addEventListener('change', function(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        reader.onload = function(e) {
          let image = new Image();
          image.src = e.target.result;
          image.onload = function() {
            preview.src = e.target.result;
          }
        }
        reader.readAsDataURL(file);
      });

      const bussiness = document.querySelector('#bussiness');
      const personal = document.querySelector('#personal');
      const fields = document.querySelectorAll('.bussiness');

      bussiness.addEventListener('change', function(e) {
        const value = e.target.value;
        if (value === '1') fields.forEach(field => field.classList.remove('hidden'));
      });

      personal.addEventListener('change', function(e) {
        const value = e.target.value;
        if (value === '0') fields.forEach(field => field.classList.add('hidden'));
      });
    </script>
  @endpush
</x-guest-layout>
