/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import Layout from "./Shared/Layout";
import route from 'ziggy-js'
import { Ziggy } from './ziggy';
import {InertiaProgress} from '@inertiajs/progress';
import AdminLayout from "./Shared/Admin/AdminLayout";
import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-bootstrap.css';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
InertiaProgress.init({ color: '#006bff' });

createInertiaApp({
    resolve: name => {
        const page = require(`./Pages/${name}`).default
        if (name.startsWith('Admin')) {
            page.layout = AdminLayout
        }
        else
        {
            page.layout = page.layout ?? Layout
        }
        return page
    },
    title: title => title ? `${title}` : 'Movate Activision KB',
    setup({ el, App, props, plugin, ZiggyVue, router }) {
        var mainApp = createApp({ render: () => h(App, props) })
        .use(plugin)
        .mixin({
            methods: {
                route: (name, params, absolute, config = Ziggy) => route(name, params, absolute, config),
            },
        })
        .use(ZiggyVue)
        .use(router)
        .use(ToastPlugin, {
            position: 'top-right'
        })

        mainApp.config.globalProperties.$route = route

        mainApp.mount(el)

    },

});


