@php
  $user = session()->get('user');
  $token = session()->get('token');
@endphp

<nav class="fixed top-0 z-50 w-full py-4 border-b border-border bg-primary md:bg-background">
  <div class="container max-w-7xl">
    <div class="items-center justify-between hidden md:flex">
      <div class="flex items-center w-full gap-4">
        <a href={{ route('landing') }} class="flex items-center space-x-2">
          <x-logo class="text-primary size-7" />
          <span class="text-lg font-semibold text-text">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <x-input placeholder="Cari Produk" class="max-w-80" />

        <div class="flex items-center gap-2">
          <a href={{ route('cart.index') }}>
            <x-icon icon='shopping-bag' label='Keranjang' />
          </a>
          <a href={{ route('messages') }}>
            <x-icon icon='message-circle' label='Chat' />
          </a>
        </div>
      </div>

      @if ($user)
        <a href={{ route('profile.index') }} class="flex items-center flex-none gap-2">
          <div class="flex flex-col space-y-0 text-sm text-end">
            <span class="font-medium text-primary">{{ $user->name }}</span>
            <span>{{ $user->email }}</span>
          </div>
          @if ($user->profile_photo_url)
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
              class="object-cover rounded-full size-10" />
          @else
            <div class="flex items-center justify-center rounded-full size-10 bg-primary">
              <i data-lucide="user" class="text-background size-5"></i>
            </div>
          @endif
        </a>
      @else
        <div class="flex items-center gap-2">
          <a href={{ route('auth.login') }}>
            <x-button>
              {{ __('Login') }}
            </x-button>
          </a>
          <a href={{ route('auth.register') }}>
            <x-button variant="secondary">
              {{ __('Register') }}
            </x-button>
          </a>
        </div>
      @endif
    </div>

    <div class="flex items-center space-x-2 md:hidden">
      <input type="search" placeholder="Cari Produk"
        class="w-full block p-2.5 text-sm border rounded-lg text-primary bg-light border-transparent focus:border-accent focus:ring-accent focus:ring-opacity-50" />
      <a href={{ route('messages') }}>
        <x-icon icon='message-circle' label='Chat' variant='secondary' />
      </a>
    </div>
  </div>
</nav>
