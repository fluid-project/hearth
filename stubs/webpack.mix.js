const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").extract();

mix.sass("resources/css/app.scss", "public/css/app.css");

if (mix.inProduction()) {
    mix.version();
}
