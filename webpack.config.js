const path = require('path');
const glob = require('glob');

// Import the default Webpack config from WordPress
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

// Import the helper to find and generate the entry points in the src directory
const { getWebpackEntryPoints } = require( '@wordpress/scripts/utils/config' );

module.exports = {
    ...defaultConfig,
    // entry: {
    //     ...getWebpackEntryPoints(),
    //     blocks: glob.sync(path.resolve(__dirname, 'app/elements/blocks/**/index.js')),
    // },
    output: {
        path: path.resolve(__dirname, 'assets/build'),
    },
};