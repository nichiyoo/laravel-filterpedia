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
    <section class="flex flex-col space-y-8">
      <div>
        <h1 class="mb-2 text-5xl font-bold text-primary">
          Profil {{ session()->get('user')->name }}.
        </h1>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta voluptate beatae nulla blanditiis ipsa
          repellendus iure dolores quisquam tempora illo.
        </p>
      </div>

      @include('partials.filters')

      <div class="grid items-start gap-8 lg:grid-cols-4">
        <nav class="p-6 border border-border rounded-xl lg:col-span-1 bg-card">
          @include('partials.sidebar')
        </nav>

        <div class="p-6 border border-border rounded-xl lg:col-span-3 bg-card">
          {{ $slot }}
        </div>
      </div>
    </section>
  </main>

  <x-mobile />
  <x-footer />

  @stack('scripts')
</body>

</html>
