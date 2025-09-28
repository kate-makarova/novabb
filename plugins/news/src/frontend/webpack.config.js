const { shareAll, withModuleFederationPlugin } = require('@angular-architects/module-federation/webpack');

module.exports = withModuleFederationPlugin({
  name: 'novaBasicNews',
  exposes: {
    './plugins/novaBasicNews/NewsComponent': './src/news.component.ts',
    './plugins/novaBasicNews/NewsModel': './src/news.model.ts',
  },

  shared: {
    ...shareAll({ singleton: true, strictVersion: true, requiredVersion: 'auto' }),
  },
  // module: {
  //   rules: [
  //     {
  //       test: /\.css$/i,
  //       use: ['style-loader', 'css-loader'], // injects CSS into JS
  //     },
  //   ],
  // },
});

