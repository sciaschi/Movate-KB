import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import Layout from "./Shared/Layout";

createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: name => {
        const page = require(`./Pages/${name}`).default
        page.layout = page.layout || Layout
        return page
    },
    title: title => title ? `${title} - Movate Activision KB` : 'Movate Activision KB',
    setup({ app, props, plugin }) {
        return createSSRApp({
            render: () => h(app, props),
        }).use(plugin)
    },
}))
