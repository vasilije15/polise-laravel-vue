<template>
  <v-app id="inspire">
    <v-main
      v-if="isLoggedIn()"
    >
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="primary"
                dark
                flat
              >
                <v-toolbar-title>Prijava na sistem</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form ref="form">
                  <v-text-field
                    v-model="username"
                    label="Ime"
                    :rules="rules.required"
                    prepend-icon="mdi-account"
                    type="text"
                    required
                    @keypress.enter="login()"
                  />

                  <v-text-field
                    v-model="password"
                    :rules="rules.required"
                    label="Šifra"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    required
                    @keypress.enter="login()"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions
                class="justify-center"
              >
                <v-btn
                  class="mb-5"
                  color="primary"
                  @click="login"
                >
                  Login
                </v-btn>
              </v-card-actions>
              <v-alert
                class="text-center"
                :value="error == '' ? false : true"
                color="error"
              >
                Pogrešno korisničko ime ili šifra
              </v-alert>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  import axios from 'axios'
  export default {
    middleware: 'auth',
    data: function () {
      return {
        username: '',
        password: '',
        error: '',
        rules: {
          required: [(v) => !!v || 'Obavezno polje'],
        },
      }
    },
    methods: {
      login () {
        this.error = ''
        if (!this.$refs.form.validate()) {
          return
        }
        const post = {
          username: this.username,
          password: this.password,
        }
        axios.post('/polise/api/login', post).then(({ data }) => {
          this.$auth.setToken(data.token, data.expires_in + Date.now(), this.username, data.name)
          this.$router.push('/')
        }).catch(error => {
          this.error = error
        })
      },
      isLoggedIn () {
        if (this.$auth.isAuthenticated()) {
          this.$router.push('/')
          alert('Već ste ulogovani!')
          return false
        }
        return true
      },
    },
  }
</script>
