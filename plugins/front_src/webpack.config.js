const { shareAll, withModuleFederationPlugin } = require('@angular-architects/module-federation/webpack');

module.exports = withModuleFederationPlugin({
  name: 'helloPlugin',
  exposes: {
  //  './HelloModule': './src/app/hello.module.ts',
    './HelloComponent': './src/app/hello.component.ts'
  },

  shared: {
    ...shareAll({ singleton: true, strictVersion: true, requiredVersion: 'auto' }),
  },

});

// const { withModuleFederationPlugin, shareAll } = require('@angular-architects/module-federation/webpack');
//
// module.exports = {
//   output: {
//     uniqueName: 'helloPlugin',
//     publicPath: 'auto',
//   },
//   resolve: {
//     extensions: ['.ts', '.js'],
//   },
//   plugins: [
//     new ModuleFederationPlugin({
//       name: 'helloPlugin',
//       filename: 'remoteEntry.js',
//       exposes: {
//         './HelloModule': './src/app/hello.module.ts',
//       },
//       shared: shareAll({ singleton: true, strictVersion: true, requiredVersion: 'auto' })
//      // shared:
//         //{
//         // '@angular/core': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
//         // '@angular/common': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
//         // '@angular/router': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
//         // '@angular/forms': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
//         // '@angular/platform-browser': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
//         // ...shareAll({ singleton: true, strictVersion: true }),
//      // },
//     }),
//   ],
// };
