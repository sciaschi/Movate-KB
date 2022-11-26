<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="{{asset('css/libraries/fontawesome/all.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.min.css')}}">

        {{-- Inertia --}}
        <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign"></script>

        {{-- Main --}}
        <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith"></script>

        @routes

        @inertiaHead
    </head>
    <body class="dark:bg-slate-900 font-sans leading-none text-gray-700 antialiased">
        @inertia

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="{{ asset('js/libraries/moment/moment.js') }}"></script>
        <script src="{{ asset('js/utils.js') }}"></script>
        <script src="{{ asset('js/table-builder.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
