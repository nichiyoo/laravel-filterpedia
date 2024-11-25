<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ env('APP_THEME', 'purple') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=bricolage-grotesque:400,500,600,700,800" rel="stylesheet" />

  @include('partials.meta')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative font-sans antialiased bg-background text-text/50">
  <main class="grid items-center min-h-screen lg:grid-cols-2">
    <div
      class="container fixed top-0 z-50 w-full py-6 mx-auto border-b bg-background lg:border-none lg:bg-transparent lg:w-auto">
      <a href={{ route('landing') }} class="flex items-center space-x-2">
        <x-logo class="text-primary size-7" />
        <span class="text-lg font-semibold text-text">{{ config('app.name', 'Laravel') }}</span>
      </a>
    </div>

    <div class="hidden lg:block">
      <img src="{{ asset('backdrops/backdrop-2.jpg') }}" class="fixed top-0 z-10 object-cover h-screen w-half " />
    </div>

    <div class="container max-w-2xl py-40">
      <x-flash />

      {{ $slot }}
    </div>
  </main>

  @stack('scripts')
</body>

</html>
