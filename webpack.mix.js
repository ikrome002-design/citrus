let mix = require('laravel-mix');

mix.webpackConfig({
    output: {
        hashFunction: 'sha256'
    }
});

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
    .styles(
        [
            'resources/assets/css/font-awesome.min.css',
            'resources/assets/css/bootstrap.min.css',
            'resources/assets/css/select2.min.css',
            'resources/assets/css/dataTables.bootstrap4.min.css',
            'resources/assets/css/admin.min.css'
        ],
        'public/css/vendor.min.css'
    )
    .styles(
        [
            'resources/assets/css/admin-custom.css'
        ],
        'public/css/admin-custom.css'
    )
    .styles(
        [
            'resources/assets/css/ionicons.min.css.map'
        ],
        'public/css/ionicons.min.css.map'
    )
    .styles(
        [
            'resources/assets/css/bootstrap.min.css.map'
        ],

        'public/css/bootstrap.min.css.map'
    )
    .scripts(
        [
            'resources/assets/js/jquery.min.js',
            'resources/assets/js/bootstrap.bundle.min.js',
            'resources/assets/js/select2.min.js',
            'resources/assets/js/jquery.dataTables.min.js',
            'resources/assets/js/dataTables.bootstrap4.min.js',
            'resources/assets/js/admin.min.js',
        ],
        'public/js/vendor.min.js'
    )
    .scripts(
        [
            'resources/assets/js/ckeditor.min.js',
        ],
        'public/js/ckeditor.min.js'
    )
    .scripts(
        [
            'resources/assets/js/Chart.min.js',
        ],
        'public/js/Chart.min.js'
    )
    .scripts(
        [
            'resources/assets/js/admin-scripts.js',
        ],
        'public/js/admin-scripts.js'
    )
    .scripts(
        [
            'resources/assets/js/bootstrap.bundle.min.js.map',
        ],
        'public/js/bootstrap.bundle.min.js.map'
    )
    .scripts(
        [
            'resources/assets/js/ckeditor.min.js.map',
        ],
        'public/js/ckeditor.js.map'
    )
    .styles(
        [

            'resources/assets/css/bootstrap.min.css',
            'resources/assets/css/lightslider.min.css',
            'resources/assets/css/font-awesome.min.css',
            'resources/assets/css/select2.min.css',
            'resources/assets/css/owl.carousel.min.css',
            'resources/assets/css/drift-basic.min.css',
            'resources/assets/css/front.css',
            'resources/assets/css/style.css'
        ],
        'public/css/style.min.css'
    )
    .styles(
        [
            'resources/assets/css/responsive.css'
        ],
        'public/css/responsive.css'
    )
    .scripts(
        [
            'resources/assets/js/jquery.min.js',
            'resources/assets/js/bootstrap.bundle.min.js',
            'resources/assets/js/lightslider.min.js',
            'resources/assets/js/select2.min.js',
            'resources/assets/js/owl.carousel.min.js',
            'resources/assets/js/Drift.min.js'
        ],
        'public/js/front.min.js'
    )
    .copyDirectory('resources/assets/fonts', 'public/fonts')
    .copyDirectory('resources/assets/images/products', 'public/storage/products')
    .copyDirectory('node_modules/datatables/media/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('resources/assets/admin-lte/img', 'public/img')
    .copyDirectory('resources/assets/images', 'public/images')
    .copyDirectory('resources/assets/pdf', 'public/pdf')
    .copy('resources/assets/js/scripts.js', 'public/js/scripts.js')
    .copy('resources/assets/js/custom.js', 'public/js/custom.js');
/*
|-----------------------------------------------------------------------
| BrowserSync
|-----------------------------------------------------------------------
|
| BrowserSync refreshes the Browser if file changes (js, sass, blade.php) are
| detected.
| Proxy specifies the location from where the app is served.
| For more information: https://browsersync.io/docs
*/
mix.browserSync({
  proxy: 'http://localhost:8000',
  host: 'localhost',
  open: true,
  watchOptions: {
    usePolling: false
  },
  files: [
    'app/**/*.php',
    'resources/views/**/*.php',
    'public/js/**/*.js',
    'public/css/**/*.css',
    'resources/docs/**/*.md'
  ]
});
