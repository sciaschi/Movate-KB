<!DOCTYPE html>
<html class="admin dark:bg-slate-800" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        <script src="https://cdn.tiny.cloud/1/b28l0twrnfpoia2kkfocy20i6yvxkem4m1nptacdtkz0aslk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="dark:bg-slate-800 font-sans antialiased">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-slate-800 shadow">
                <div class="dark:text-slate-400 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        @if (isset($sidebar))
            {{ $sidebar }}
        @endif
        <div id="a-nav" class="sidebar bg-gray-300 dark:bg-gray-800 dark:border-slate-700">
            <ul class="nav flex-column" id="nav_accordion">
                <li class="nav-item bg-gray-300 dark:bg-gray-800">
                    <a class="nav-link border-b border-b-indigo-600" href="#"><i class="fa-solid fa-gauge-high"></i> Dashboard </a>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link border-b border-indigo-600" href="#"> Users  </a>
                    <ul class="submenu collapse">
                        <li class="border-b border-b-indigo-600"><a class="nav-link" href="#">Create User </a></li>
                        <li class="border-b border-b-indigo-600"><a class="nav-link" href="#">Edit User</a></li>
                        <li class="border-b border-b-indigo-600"><a class="nav-link" href="#">Submenu item 3 </a> </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link border-b border-b-indigo-600" href="#"> Moderator Accuracies </a>
                </li>
            </ul>
        </div>
        <!-- Page Content -->
        <main class="dark:bg-slate-900">
            {{ $slot }}
        </main>

        <script>
            var lightMode = document.getElementById('toggle-check')

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
            });

            document.addEventListener("DOMContentLoaded", function(){
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

                document.querySelectorAll('.sidebar .nav-link').forEach(function(element){

                    element.addEventListener('click', function (e) {

                        let nextEl = element.nextElementSibling;
                        let parentEl  = element.parentElement;

                        if(nextEl) {
                            e.preventDefault();
                            let mycollapse = new bootstrap.Collapse(nextEl);

                            if(nextEl.classList.contains('show')){
                                mycollapse.hide();
                            } else {
                                mycollapse.show();
                                // // find other submenus with class=show
                                // var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                                // // if it exists, then close all of them
                                // if(opened_submenu){
                                //     new bootstrap.Collapse(opened_submenu);
                                // }
                            }
                        }
                    }); // addEventListener
                }) // forEach
            });
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
