// webpack.mix.js

const mix               = require('laravel-mix');
const tailwindcss       = require('tailwindcss'); /* Add this line at the top */
const LiveReloadPlugin  = require('webpack-livereload-plugin');
const minifier          = require('minifier');
const path              = require('path')

mix.js('resources/js/app.js', 'js')
    .vue({ runtimeOnly: (process.env.NODE_ENV || 'production') === 'production' })
    .copy('resources/js/search.js', 'public/js/search.js')
    .copy('resources/js/dashboard.js', 'public/js/dashboard.js')
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


module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
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
