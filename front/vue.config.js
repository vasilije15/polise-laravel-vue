const ip = '192.168.100.100'
const port = 8000

module.exports = {
  publicPath: '/polise',
  devServer: {

    proxy: {
      '^/api': {
        target: 'http://' + ip + ':' + port,
      },
    },
    disableHostCheck: true,
  },

  transpileDependencies: ['vuetify'],

  pluginOptions: {
    i18n: {
      locale: 'en',
      fallbackLocale: 'en',
      localeDir: 'locales',
      enableInSFC: false,
    },
  },
}
