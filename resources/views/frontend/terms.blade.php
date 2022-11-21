<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl light:text-gray-800 dark:text-slate-400 leading-tight">
            {{ __('Search Terms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:search-term-base></livewire:search-term-base>
        </div>
    </div>

    @push('scripts')
        <script src="{{asset('js/search.js')}}"></script>
        <script src="{{ asset('js/terms.js') }}"></script>
        <script>
            Search.init();
        </script>
    @endpush
</x-app-layout>
