let mix = require('laravel-mix');

mix.js('src/js/script.js', '.')
    .sass('src/scss/style.scss', '.')
    .options({processCssUrls: false});

if (mix.inProduction()) {
    mix.copy('./*.php', './dist', false)
        .copy('./style.css', './dist', false)
        .copy('./script.js', './dist', false)
        .copy('./screenshot.png', './dist', false)
        .copy('./images/', './dist/images', false)
        .copy('./wp/', './dist/wp', false)
        .copy('./vendor/', './dist/vendor', false)
        .copy('./partials/', './dist/partials', false)
        .copy('./templates/', './dist/templates', false)
        .copy('./*.md', './dist', false);
}
