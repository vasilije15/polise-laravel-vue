<template>
  <v-container
    v-if="isLoggedIn()"
    id="regular-tables"
    fluid
    tag="section"
  >
    <v-card>
      <v-card-title class="pb-5">
        Sve informacije o vozilima
        <v-spacer />
        <v-text-field
          v-model="search"
          label="Pretraži"
          append-icon="mdi-magnify"
          single-line
          hide-details
        />
      </v-card-title>
      <v-progress-linear v-show="isLoading" />
      <v-data-table
        :headers="headers"
        :items="cars"
        :search="search"
        :single-expand="singleExpand"
        :expanded.sync="expanded"
        item-key="broj_sasije"
        show-expand
        class="elevation-1 mt-2 mytable"
        :loading="isLoading"
        loading-text="Učitavanje podataka"
        :footer-props="{itemsPerPageText: 'Broj redova'}"
        :sort-by="['godina_proizvodnje']"
        :sort-desc="[true, false]"
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
        <template v-slot:expanded-item="{ item }">
          <td
            :colspan="headers.length"
            class="pa-10"
          >
            <p class="text-lg-h4">
              Dodatne informacije o vozilu sa registarskom oznakom: <kbd>{{ item.reg_oznaka_vozila }} </kbd>
            </p>
            <p class="text-lg-h4">
              <b>Broj motora: </b> {{ item.broj_motora }}
            </p>
            <p class="text-lg-h4">
              <b>Namjena: </b> {{ item.namjena }}
            </p>
            <p class="text-lg-h4">
              <b>Snaga KW: </b> {{ item.snaga_kw }}
            </p>
            <p class="text-lg-h4">
              <b>Zapremina CCM: </b> {{ item.zapremina_ccm }}
            </p>
            <p class="text-lg-h4">
              <b>Broj mjesta: </b> {{ item.broj_mjesta }}
            </p>
            <p class="text-lg-h4">
              <b>Nosivost KG: </b> {{ item.nosivost_kg }}
            </p>
          </td>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>

  import axios from 'axios'

  export default {
    name: 'Vozila',
    data () {
      return {
        search: '',
        isLoading: true,
        expanded: [],
        singleExpand: true,
        headers: [
          {
            text: 'Registarska oznaka vozila',
            align: 'start',
            value: 'reg_oznaka_vozila',
          },
          { text: 'Vrsta', value: 'vrsta' },
          { text: 'Marka i tip', value: 'marka_tip' },
          { text: 'Broj šasije', value: 'broj_sasije' },
          { text: 'Godina proizvodnje', value: 'godina_proizvodnje' },
          { text: '', value: 'data-table-expand' },
        ],
        cars: [],
      }
    },
    mounted () {
      axios
        .get('/api/cars')
        .then(response => {
          this.cars = response.data
          this.isLoading = false
        })
        .catch(error => {
          alert(error.message)
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
