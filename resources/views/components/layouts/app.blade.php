<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    @livewireStyles
</head>
<body class="bg-slate-950 text-slate-50">
<x-layouts.app.header/>
<div class="mx-24 mt-12">
    {{ $slot }}
</div>

@fluxScripts
@livewireScripts
</body>
</html>
