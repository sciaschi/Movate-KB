<template>
    <div class="sidebar overflow-y-auto overflow-x-hidden h-full shadow-md bg-white absolute dark:bg-slate-800 border-b border-gray-100 dark:border-slate-500">
        <div class="container sidebar-header">

        </div>
        <ul class="sidebar-list relative">
            <li class="relative nav-item">
                <Link class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-ellipsis
                whitespace-nowrap transition duration-300 ease-in-out" :href="route('admin.dashboard')" :class="$page.url === route('admin.dashboard') ? 'active' : ''">
                    <span class="text-base"><i class="fa-solid fa-chart-area"></i> Dashboard</span>
                </Link>
            </li>
            <li class="relative nav-item">
                <Link class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis
                whitespace-nowrap hover:text-gray-900 hover:bg-gray-100
                transition duration-300 ease-in-out" :href="route('admin.users.index')" :class="$page.url === route('admin.users.index') ? 'active' : ''">
                    <span class="text-base"><i class="fa-solid fa-users"></i> Users</span>
                </Link>
            </li>
            <li class="relative nav-item">
                <Link class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700
                text-ellipsis whitespace-nowrap hover:text-gray-900 hover:bg-gray-100 transition duration-300
                ease-in-out" :href="route('admin.accuracy-scores')" :class="$page.url === route('admin.accuracy-scores') ? 'active' : ''">
                    <span class="text-base"><i class="fa-solid fa-percent"></i> Accuracy Scores</span>
                </Link>
            </li>
            <li class="relative nav-item">
                <Link class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700
                text-ellipsis whitespace-nowrap hover:text-gray-900 hover:bg-gray-100 transition duration-300
                ease-in-out" :href="route('dashboard')" :class="$page.url === route('admin.accuracy-scores') ? 'active' : ''">
                    <span class="text-base"><i class="fa-regular fa-square-caret-left"></i> Back to User Dashboard</span>
                </Link>
            </li>
            <li class="relative text-center">
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
            </li>
        </ul>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import route from "ziggy-js/src/js";

export default {
    name: "AdminNavigation",
    methods: {route},
    components: {
        Link
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
