<template>
    <nav class="bg-white dark:bg-slate-800 dark:border-slate-500">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a :href="route('dashboard')">
                            <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                                <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex dark:text-slate-400 align-items-center">
                        <Link class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400
                    dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700
                    light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300
                    transition duration-150 ease-in-out" :href="route('dashboard')" :class="$page.url === route('dashboard') ? 'active' : ''">
                            Dashboard
                        </Link>
                        <Link class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400
                    dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700
                    light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300
                    transition duration-150 ease-in-out" :href="route('terms')" :class="$page.url === route('terms') ? 'active' : ''">
                            Terms
                        </Link>
                        <Link class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400
                    dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700
                    light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300
                    transition duration-150 ease-in-out" :href="route('translate')" :class="$page.url === route('translate') ? 'active' : ''">
                            Translate
                        </Link>
                        <Link class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400
                    dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700
                    light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300
                    transition duration-150 ease-in-out" :href="route('audits')" :class="$page.url === route('audits') ? 'active' : ''">
                            Audits
                        </Link>
                        <Link class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400
                    dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700
                    light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300
                    transition duration-150 ease-in-out" :href="route('admin.dashboard')" v-if="$page.props.auth.user.role == 'Admin'">
                            Admin Dashboard
                        </Link>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <input type="checkbox" id="toggle-check">
                    <label for="toggle-check" class="toggle-label">
                        <div class="toggle-container">
                            <div class="toggle-light-icon icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                            </div>
                            <div class="toggle-dark-icon icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                            </div>
                            <div class="toggle-circle"></div>
                        </div>
                    </label>
                    <PageCounter></PageCounter>
                    <Dropdown width="w-48" class="float-right">
                        <template v-slot:trigger>
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700
                        hover:border-gray-300 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:border-gray-300
                        focus:outline-none focus:text-gray-700 focus:border-gray-300 dark:focus:text-gray-300
                        dark:focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ $page.props.auth.user ? $page.props.auth.user.name : "Welcome Guest!" }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </template>

                        <template v-slot:content>
                            <!-- Authentication -->
                            <form ref="logout" method="POST" :action="route('logout')">
                                <input type="hidden" name="_token" :value="csrf">

                                <dropdown-link @click="submit">
                                    Log Out
                                </dropdown-link>
                            </form>
                        </template>
                    </Dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <responsive-nav-link :href="route('dashboard')">
                    Dashboard
                </responsive-nav-link>
                <responsive-nav-link :href="route('terms')">
                    Search Terms
                </responsive-nav-link>
                <responsive-nav-link :href="route('translate')">
                    Translate
                </responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user ? $page.props.auth.user.name : "Guest" }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user ? $page.props.auth.user.email : "" }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        <responsive-nav-link :href="route('logout')"
                                               v-on:click="submit">
                            Log Out
                        </responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {ref} from "vue";
import route from "ziggy-js";
let open = ref(true);

</script>

<script>
import Dropdown from "./Widgets/dropdown";
import DropdownLink from "./Widgets/dropdown-link";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import ResponsiveNavLink from "./Widgets/responsive-nav-link";
import PageCounter from "./Widgets/page-counter.vue";

export default {
    components: {
        PageCounter,
        ResponsiveNavLink,
        Dropdown,
        DropdownLink,
        Link
    },
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    methods: {
        submit : function(e){
            e.preventDefault();
            e.target.closest('form').submit();
        }
    },
    mounted() {
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
    }
}
</script>

<style scoped>

</style>
