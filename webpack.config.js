module.exports = {
	entry: {
		'/': './my-block-notification.js'
	},
	output: {
		path: __dirname,
		filename: 'my-block-notification.min.js',
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
