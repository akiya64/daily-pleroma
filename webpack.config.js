const path = require('path')
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' )
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const RtlCssPlugin = require('@wordpress/scripts/plugins/rtlcss-webpack-plugin')

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
	},
	plugins: [
		...defaultConfig.plugins.filter((v)=> !(v instanceof MiniCssExtractPlugin || v instanceof RtlCssPlugin)),
		new MiniCssExtractPlugin({
			filename: '[name]/index.css',
		})
	]
}
