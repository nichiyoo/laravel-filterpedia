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
  <x-navbar />

  <main class="container py-40 lg:pb-20 max-w-7xl min-h-layout">
    <x-flash />
    {{ $slot }}
  </main>

  <x-mobile />
  <x-footer />

  @stack('scripts')
</body>

</html>
