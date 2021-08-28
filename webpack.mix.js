const mix = require('laravel-mix');

//const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const imageminMozjpeg = require('imagemin-mozjpeg');

//require('laravel-mix-webp');
//require('laravel-mix-polyfill');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// ������������ JS
//.js('resources/assets/js/main.js','public/assets/js')
 
mix.scripts([
	'resources/assets/admin/plugins/jquery/jquery.min.js',
	'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
	'resources/assets/admin/js/adminlte.min.js',
	'resources/assets/admin/js/select2/select2.full.min.js',
	'resources/assets/admin/js/app.js'
], 'public/assets/admin/js/admin.js');
mix.js(['resources/js/CKEditor.js'], 'public/assets/admin/js/CKEditor.js');
//mix.copyDirectory('resources/assets/admin/img','public/assets/admin/img');
mix.copy('resources/assets/admin/css/adminlte.min.css.map','public/assets/admin/css/adminlte.min.css.map');
mix.copyDirectory('resources/assets/admin/plugins/fontawesome-free/webfonts','public/assets/admin/webfonts');
mix.styles([
	'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
	'resources/assets/admin/css/adminlte.min.css',
	'resources/assets/admin/css/select2/select2-bootstrap4.min.css',
	'resources/assets/admin/css/select2/select2.min.css'
], 'public/assets/admin/css/admin.css');
// ��������������� SASS � CSS
mix.sass(
    'resources/assets/site/scss/main.scss', // ���� ������������ �������� � webpack.mix.js
    'public/assets/site/css/' // ���� ������������ �������� � webpack.mix.js
)
// �������������� ��������� mix postCss
.options({
    processCssUrls: false, // ��������� �������������� ���������� URL � CSS
    postCss: [
        // ��������� ��������� �������� � CSS
        require('autoprefixer')({
            cascade: false, // ��������� ������������ ��������� ���������
        }),
        // ���������� ����� �� �����-��������
        require('postcss-sort-media-queries'),
    ]
})
// ����������� webpack ��� ��������� �����������
.webpackConfig({
    plugins: [
	    // �������� �������� �� �������� �������� � ��������� �������
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: 'resources/assets/admin/img', // ���� ������������ �������� � webpack.mix.js
                    to: 'assets/admin/img', // ���� ������������ �������� public/
                }
            ]
        }),
        // ������������ �������� �����������
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif)$/i,
            plugins: [
                imageminMozjpeg({
                    quality: 80,
                    progressive: true,
                })
            ]
        })
    ]
})
// �������� ������������
.version();

 
/*mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
*/
