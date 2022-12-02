// webpack.mix.js

const mix               = require('laravel-mix');
const tailwindcss       = require('tailwindcss'); /* Add this line at the top */
const LiveReloadPlugin  = require('webpack-livereload-plugin');
const minifier          = require('minifier');
const path              = require('path')

module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js')
        },
        extensions: ['.js', '.vue', '.json'],
    },
    plugins: [
        new LiveReloadPlugin()
    ],
    devServer: {
        allowedHosts: 'all',
    }
}

mix.webpackConfig({
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
        },
    },
});

mix
.js([
    'resources/js/app.js'
], 'js')
.vue()
.copy('resources/js/table-builder.js', 'public/js/table-builder.js')
.copy('resources/js/utils.js', 'public/js/utils.js')
.sass('resources/css/app.scss', 'css')
.options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
})
.then(() => {
    minifier.minify('public/css/app.css');
})
.version()
.sourceMaps();

