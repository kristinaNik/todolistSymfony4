var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addEntry('select_username', './assets/js/select_username.js')
    .addEntry('main', './assets/css/main.css')
    // .addStyleEntry('global', './assets/css/global.scss')
    // .addStyleEntry('global', './assets/css/main.css')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction());

module.exports = Encore.getWebpackConfig();
