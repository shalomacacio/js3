<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content={{csrf_token()}}>

    {{-- Title --}}
    <title>JS3-Relatórios</title>

    {{-- Custom stylesheets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
    @yield('css')
    
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    @include('layouts.admin-partials.navbar-rel')
      @yield('filter')
      @yield('table')
    @include('layouts.admin-partials.footer')
  </div>
  @include('layouts.admin-partials.scripts')
  @yield('javascript')
</body>

</html>
