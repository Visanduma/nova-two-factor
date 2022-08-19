let mix = require('laravel-mix')

require('./nova.mix')
let tailwindcss = require("tailwindcss")

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .vue({ version: 3 })
  // .css('resources/sass/tool.scss', 'css')
    .postCss("resources/sass/tool.css", "css", [tailwindcss("tailwind.config.js")])
  .nova('visanduma/nova-two-factor')
