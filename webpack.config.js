const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const glob = require( 'glob' )
let widgets = glob.sync('./assets/js/widgets/**/*.js')
let shortcodes = glob.sync('./assets/js/shortcodes/**/*.js')

console.log(widgets)
console.log(shortcodes)

module.exports = {
  ...defaultConfig,
  entry: {
    widgets: widgets,
    shortcodes: shortcodes,
  },
  output: {
    filename: '[name].bundle.js',
  },
  module: {
    ...defaultConfig.module,
    rules: [
      ...defaultConfig.module.rules,
    ],
  },
  plugins: [...defaultConfig.plugins],
  optimization: {
    splitChunks: {
      chunks: 'all',
    },
  }
};
