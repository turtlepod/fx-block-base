const packageJson = require('./package.json');

module.exports = {
	entry: packageJson.webpackConfig.entry,
	output: {
		path: __dirname + packageJson.webpackConfig.outputDir,
		filename: '[name]/editor.min.js',
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				use: {
					loader: "babel-loader",
				},
				exclude: /(node_modules|bower_components)/,
			}
		]
	}
};
