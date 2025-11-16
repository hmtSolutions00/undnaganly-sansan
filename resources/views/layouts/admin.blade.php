<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin • undanganly.com')</title>

  {{-- Bootstrap 5 CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons (untuk ikon nav & tombol) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  {{-- CSS kustom --}}
  <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
  @stack('styles')
</head>
<body class="bg-app">

  {{-- Header --}}
  @include('partials.header')

  {{-- Konten --}}
  <main class="container pb-6 mb-6 pt-3">
    @yield('content')
  </main>

  {{-- Bottom Menu --}}
  @include('partials.menu')

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- JS kustom --}}
  <script src="{{ asset('/js/admin.js') }}"></script>
  @stack('scripts')
</body>
</html>
