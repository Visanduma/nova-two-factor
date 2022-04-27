let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .vue({ version: 2 })
  .sass('resources/sass/tool.scss', 'css')
  .webpackConfig({
    externals: {
      Vue: 'vue',
    },
  })
