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
        <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

        {{-- Ping CRM --}}
        <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>

        <script src="{{ mix('/js/app.js') }}" defer></script>

        @inertiaHead

    </head>
    <body class="font-sans leading-none text-gray-700 antialiased">
        @include('layouts.navigation')

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-slate-800 shadow">
                    <div class="dark:text-slate-400 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @inertia
            </main>
        </div>

        <script>
            var lightMode = document.getElementById('toggle-check')

            if(localStorage.theme == 'light'){
                lightMode.checked = true;

                setTimeout(function(){
                    localStorage.theme = 'light';
                    document.documentElement.classList.remove("dark")
                },100);
            }else{
                lightMode.checked = false;

                setTimeout(function(){
                    localStorage.theme = 'dark';
                    document.documentElement.classList.add("dark")
                },100);
            }

            lightMode.addEventListener('change',function(){
                if(localStorage.theme == 'light') {
                    setTimeout(function(){
                        localStorage.theme = 'dark';
                        lightMode.checked = false;
                        document.documentElement.classList.add("dark")
                    },100);

                }else{
                    setTimeout(function(){
                        localStorage.theme = 'light';
                        lightMode.checked = true;
                        document.documentElement.classList.remove("dark")
                    },100);
                }
            })
        </script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="{{asset('js/libraries/moment/moment.js')}}"></script>
        <script src="{{ asset('js/utils.js') }}"></script>
    </body>
</html>
