<x-app-layout>
    <x-slot name="header">
        <h2 class="dark:text-slate-400 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-slate-800 border-b border-gray-200">
                    <h2 class="header-text text-gray-800 font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                        {{ __('Recently Added Terms') }}
                    </h2>
                    <livewire:recently-added-terms-component></livewire:recently-added-terms-component>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-800">
                <h2 class="header-text font-semibold dark:text-slate-400 leading-tight dark:border-b-2 dark:border-indigo-600">
                    {{ __('Trending News') }} @can('add-trend')<button id="add-trend-btn" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i></button>@endcan
                </h2>
                <div class="container">
                    <div id="trend-spinner" class="d-flex justify-content-center">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="trends-grid" class="row d-none align-items-stretch"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{asset('js/dashboard.js')}}"></script>
        <script>
            dashboard.init();
        </script>
    @endpush
</x-app-layout>
