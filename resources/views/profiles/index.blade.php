<x-profile-layout>
  <div class="mb-4">
    <h2 class="text-xl font-semibold text-primary">
      {{ __('Edit Profil') }}
    </h2>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, facilis!
    </p>
  </div>

  <div class="flex flex-col w-full mb-6 space-y-1">
    <x-label for="avatar">Foto Profil</x-label>
    <img id="preview" src="{{ $user->profile_photo_url }}" alt="avatar"
      class="object-cover w-full md:w-48 rounded-xl aspect-frame md:aspect-square">
  </div>

  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
    class="grid gap-6 lg:grid-cols-2">
    @csrf

    <div>
      <x-label for="name">Nama</x-label>
      <x-input name="name" id="name" value="{{ $user->name }}" />
      <x-error field="name" />
    </div>

    <div>
      <x-label for="avatar">Pilih Foto</x-label>
      <x-input name="avatar" id="avatar" type="file" accept="image/*" class="file:hidden" />
      <x-error field="avatar" />
    </div>

    <div>
      <x-label for="email">Email</x-label>
      <x-input name="email" id="email" value="{{ $user->email }}" disabled readonly />
      <x-error field="email" />
    </div>

    <div>
      <x-label for="phone">Telepon</x-label>
      <x-input name="phone" id="phone" value="{{ $user->user_detail->telepon }}" />
      <x-error field="phone" />
    </div>

    <div class="col-span-full">
      <x-label for="address">Alamat</x-label>
      <x-textarea name="address" id="address">{{ $user->user_detail->alamat }}</x-textarea>
      <x-error field="address" />
    </div>

    <div>
      <x-label for="province">Provinsi</x-label>
      <x-select name="province" id="province">
        @foreach ($provinces as $province)
          <option value="{{ $province->id }}" {{ $user->user_detail->provinsi_id == $province->id ? 'selected' : '' }}>
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

    @push('scripts')
      <script>
        const avatar = document.querySelector('#avatar');
        const preview = document.querySelector('#preview');

        avatar.addEventListener('change', function(e) {
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
      </script>
    @endpush
</x-profile-layout>
