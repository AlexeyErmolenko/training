const mix = require('laravel-mix');
const path = require('path');

const appDir = path.resolve(__dirname, 'resources/assets/app');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js(`${appDir}/main.js`, 'public/assets/js')
  .sass('resources/assets/sass/app.scss', 'public/assets/styles')
  .copyDirectory('resources/assets/img', 'public/assets/img')
  // .copyDirectory('resources/assets/fonts', 'public/assets/fonts')
  .copyDirectory('node_modules/swagger-ui-dist', 'public/swagger-ui')
  .disableNotifications()
  .version();

if (!mix.inProduction()) {
  mix.sourceMaps();
}
