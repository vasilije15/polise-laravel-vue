export default function (Vue) {
  Vue.auth = {
    setToken (token, expiration, username, name) {
      localStorage.setItem('token', token)
      localStorage.setItem('expiration', expiration)
      localStorage.setItem('username', username)
      localStorage.setItem('name', name)
    },
    getToken () {
      var token = localStorage.getItem('token')
      var expiration = localStorage.getItem('expiration')

      if (!token || !expiration) {
        return null
      }

      if (Date.now() > parseInt(expiration)) {
        this.destroyToken()
        return null
      }
      return token
    },
    destroyToken () {
      localStorage.removeItem('token')
      localStorage.removeItem('expiration')
      localStorage.removeItem('username')
    },
    isAuthenticated () {
      return this.getToken() != null
    },
  }
  Object.defineProperties(Vue.prototype, {
    $auth: {
      get () {
        return Vue.auth
      },
    },
  })
}
