<template>
    <a :class="active ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 ' +
     'text-gray-900 dark:text-indigo-300 focus:outline-none focus:border-indigo-700 dark:focus:border-indigo-300 ' +
      'transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm ' +
       'font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-400 ' +
        'dark:hover:text-gray-300 dark:hover:border-gray-300 focus:outline-none light:focus:text-gray-700 ' +
         'light:focus:border-gray-300 dark:focus:text-slate-300 dark:focus:border-gray-300 ' +
          'transition duration-150 ease-in-out'">
        <slot />
    </a>

</template>

<script>
import { mergeDataIntoQueryString, router, shouldIntercept } from '@inertiajs/core'
import { h } from 'vue'

export default {
    name: "nav-link",
    props: {
        as: {
            type: String,
            default: 'a',
        },
        data: {
            type: Object,
            default: () => ({}),
        },
        href: {
            type: String,
        },
        method: {
            type: String,
            default: 'get',
        },
        replace: {
            type: Boolean,
            default: false,
        },
        preserveScroll: {
            type: Boolean,
            default: false,
        },
        preserveState: {
            type: Boolean,
            default: null,
        },
        only: {
            type: Array,
            default: () => [],
        },
        headers: {
            type: Object,
            default: () => ({}),
        },
        queryStringArrayFormat: {
            type: String,
            default: 'brackets',
        },
    },
    setup(props, { slots, attrs }) {
        return (props) => {
            const as = props.as.toLowerCase()
            const method = props.method.toLowerCase()
            const [href, data] = mergeDataIntoQueryString(method, props.href || '', props.data, props.queryStringArrayFormat)

            if (as === 'a' && method !== 'get') {
                console.warn(
                    `Creating POST/PUT/PATCH/DELETE <a> links is discouraged as it causes "Open Link in New Tab/Window" accessibility issues.\n\nPlease specify a more appropriate element using the "as" attribute. For example:\n\n<Link href="${href}" method="${method}" as="button">...</Link>`,
                )
            }

            return h(
                props.as,
                {
                    ...attrs,
                    ...(as === 'a' ? { href } : {}),
                    onClick: (event) => {
                        if (shouldIntercept(event)) {
                            event.preventDefault()

                            router.visit(href, {
                                data: data,
                                method: method,
                                replace: props.replace,
                                preserveScroll: props.preserveScroll,
                                preserveState: props.preserveState ?? method !== 'get',
                                only: props.only,
                                headers: props.headers,
                                onCancelToken: attrs.onCancelToken || (() => ({})),
                                onBefore: attrs.onBefore || (() => ({})),
                                onStart: attrs.onStart || (() => ({})),
                                onProgress: attrs.onProgress || (() => ({})),
                                onFinish: attrs.onFinish || (() => ({})),
                                onCancel: attrs.onCancel || (() => ({})),
                                onSuccess: attrs.onSuccess || (() => ({})),
                                onError: attrs.onError || (() => ({})),
                            })
                        }
                    },
                },
                slots,
            )
        }
    },
}
</script>

<style scoped>

</style>
