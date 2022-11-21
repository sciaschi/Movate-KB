<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="dark:text-slate-400 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="admin-container" class="container-fluid mh-100 flex h-full ml-0">
        <div class="admin-content container">
            @yield('content')
        </div>
    </div>
</x-admin-app-layout>
