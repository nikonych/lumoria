<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-main-bg bg-cover bg-center flex justify-start items-stretch p-4 sm:p-10">
<div class="w-full sm:w-2/3 md:w-2/3 lg:w-2/5 bg-slate-950 rounded-lg">
    <div class="h-full overflow-y-auto">
        {{ $slot }}
    </div>
</div>
@fluxScripts
</body>
</html>
