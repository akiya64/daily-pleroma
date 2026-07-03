const path = require('path')
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' )

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry,
		settings: './src/settings/index.js',
		tools: './src/tools/index.js'
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(__dirname, 'page'),
		filename: '[name]/index.bundle.js'
	}
}
