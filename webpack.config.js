const webpack = require('webpack');
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const packageJson = require('./package.json');
const isProduction = process.argv[process.argv.indexOf('--mode') + 1] === 'production';

let entries = packageJson.webpackConfig.entry;
const customBlocks = packageJson.webpackConfig.customBlocks;

customBlocks.forEach((block)=>{
	entries['custom-blocks/' + block + '/block'] = "./blocks/custom-blocks/" + block + "/block.js";
	entries['custom-blocks/' + block + '/style'] = "./blocks/custom-blocks/" + block + "/style.css";
	entries['custom-blocks/' + block + '/editor-style'] = "./blocks/custom-blocks/" + block + "/editor-style.css";
});

module.exports = {
	entry: entries,
	output: {
		path: __dirname + packageJson.webpackConfig.outputDir,
		filename: '[name].js',
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '[name].css'
		}),
	],
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				use: {
					loader: "babel-loader",
				},
				exclude: /(node_modules|bower_components)/,
			},
			{
				test: /\.css$/i,
				use: [MiniCssExtractPlugin.loader, "css-loader"],
				exclude: /(node_modules|bower_components)/,
			}
		]
	},
	optimization: {
		minimizer: [
			new TerserPlugin(),
			new CssMinimizerPlugin(),
		],
		minimize: isProduction,
	},
};
