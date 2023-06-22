const { defineConfig } = require("@vue/cli-service");

module.exports = defineConfig({
    configureWebpack: {
        entry: "./src/main.js",
        devServer: {
            hot: true,
        },
        watch: true,
        watchOptions: {
            ignored: /node_modules/,
            poll: 1000,
        },
    },
    chainWebpack: config => {
        config.module
          .rule('css')
          .test(/\.css$/)
          .use('style-loader')
          .loader('style-loader')
    },
    transpileDependencies: true,
});