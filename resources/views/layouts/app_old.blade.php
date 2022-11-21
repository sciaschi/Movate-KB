<!DOCTYPE html>
<html class="dark:bg-slate-800" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="{{asset('css/libraries/fontawesome/fontawesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/libraries/fontawesome/all.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet">

        <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">

        @livewireStyles
        @inertiaHead

        <script src="https://cdn.tiny.cloud/1/b28l0twrnfpoia2kkfocy20i6yvxkem4m1nptacdtkz0aslk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
        @inertia

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

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

                {{ $slot }}
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
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
        <script src="{{asset('js/libraries/moment/moment.js')}}"></script>
        <script src="{{ asset('js/utils.js') }}"></script>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>

        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
