<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    @livewireStyles
</head>
<body class="bg-slate-950 text-slate-50">
<x-layouts.app.header/>
<div class="min-h-screen bg-main-bg bg-cover bg-center flex justify-start items-stretch">
{{ $slot }}
</div>

@fluxScripts
@livewireScripts
</body>
</html>
