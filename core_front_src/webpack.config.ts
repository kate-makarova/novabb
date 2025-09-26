const ModuleFederationPlugin = require('webpack/lib/container/ModuleFederationPlugin');

module.exports = {
  plugins: [
    new ModuleFederationPlugin({
      name: 'novaBB',
      remotes: {}, // Plugins will be added dynamically
      shared: {
        '@angular/core': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
        '@angular/common': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
        '@angular/router': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
        '@angular/platform-browser': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
        '@angular/forms': { singleton: true, strictVersion: true, requiredVersion: '20.3.2' },
      }
    })
  ]
};
