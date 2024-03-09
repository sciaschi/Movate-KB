// webpack.mix.js
const tailwindcss       = require('tailwindcss'); /* Add this line at the top */
const mix                        = require('laravel-mix');
const LiveReloadPlugin  = require('webpack-livereload-plugin');
const minifier          = require('minifier');
const path              = require('path')

module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
            '@jsAssets': path.resolve(__dirname, './resources/js')
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
            '@jsAssets': path.resolve(__dirname, './resources/js'),
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

