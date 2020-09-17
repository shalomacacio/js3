<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content={{csrf_token()}}>

    {{-- Title --}}
    <title>JS3</title>

    {{-- Custom stylesheets --}}
    @include('layouts.admin-partials.styles')
    @yield('css')
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  @include('layouts.admin-partials.header')
  @include('layouts.admin-partials.sidebar')
    @yield('content')
  @include('layouts.admin-partials.footer')
  @include('layouts.admin-partials.scripts')
  @yield('javascript')
</body>

</html>
