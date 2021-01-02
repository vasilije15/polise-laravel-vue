<template>
  <v-container
    v-if="isLoggedIn()"
    id="regular-tables"
    fluid
    tag="section"
  >
    <v-card>
      <v-card-title>
        <v-text-field
          v-model="search"
          label="Pretraži"
          single-line
          hide-details
          append-icon="mdi-magnify"
        />
      </v-card-title>
      <v-progress-linear v-show="isLoading" />
      <v-data-table
        :headers="headers"
        :items="insureds"
        :search="search"
        class="mytable"
        :loading="isLoading"
        loading-text="Učitavanje podataka"
        no-data-text="Nema podataka"
        no-results-text="Nema podataka koji se poklapaju"
        :footer-props="{itemsPerPageText: 'Broj redova'}"
      >
        <template v-slot:no-data>
          <div class="text-center mt-5 pl-15 pr-15">
            <v-alert
              color="error"
              icon="mdi-alert-circle"
            >
              Nema podataka
            </v-alert>
          </div>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>

  import axios from 'axios'

  export default {
    name: 'Osiguranici',
    data () {
      return {
        search: '',
        isLoading: true,
        headers: [
          {
            text: 'Ime/Naziv',
            align: 'start',
            value: 'ime_naziv_osiguranik',
          },
          { text: 'JMBG/PIB', value: 'jmbg_pib_osiguranik' },
          { text: 'Grad', value: 'grad_osiguranik' },
          { text: 'Ulica i broj', value: 'ulica_broj_osiguranik' },
          { text: 'Broj telefona', value: 'br_tel_osiguranik' },
        ],
        insureds: [],
      }
    },
    mounted () {
      axios
        .get('/api/insureds')
        .then(response => {
          this.insureds = response.data
          this.isLoading = false
        })
        .catch(error => {
          alert(error)
        })
    },
    methods: {
      isLoggedIn () {
        if (!this.$auth.isAuthenticated()) {
          this.$router.push('/login')
          alert('Morate se ulogovati')
          return false
        }
        return true
      },
    },
  }

</script>

<style>
  .mytable table thead th {
    font-size: 16px !important;
    font-weight: bold !important;
    color: black !important;
  }
</style>
