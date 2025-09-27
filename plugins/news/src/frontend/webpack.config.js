const { shareAll, withModuleFederationPlugin } = require('@angular-architects/module-federation/webpack');

module.exports = withModuleFederationPlugin({
  name: 'helloPlugin',
  exposes: {
    './plugins/news/NewsComponent': './src/news.component.ts',
    './plugins/news/NewsModel': './src/news.model.ts',
  },

  shared: {
    ...shareAll({ singleton: true, strictVersion: true, requiredVersion: 'auto' }),
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: ['style-loader', 'css-loader'], // injects CSS into JS
      },
    ],
  },
});

