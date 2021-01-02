<template>
  <v-container
    v-if="isLoggedIn()"
    id="dashboard"
    fluid
    tag="section"
  >
    <v-row
      align="center"
      justify="center"
      align-content-lg="center"
    >
      <v-col
        cols="12"
        lg="12"
        md="12"
      >
        <v-card>
          <v-card-title class="pb-5 text-lg-h3">
            Polise koje ističu u narednih
            <v-text-field
              v-model="nextDaysFromInput"
              type="number"
              class="shrink ml-5 mt-5 mr-2"
              label="Unesite broj dana"
              solo
              @keyup.enter.native="getCardsInNextDays"
            /> dana
          </v-card-title>
          <v-card-text>
            <span class="text-lg-h3">Današnji datum <b>{{ new Date().toJSON().slice(0,10).replace(/-/g,'-') }} </b> </span>
          </v-card-text>
          <v-progress-linear v-show="isLoading" />
          <v-data-table
            :headers="headers"
            :items="tableData"
            :mobile-breakpoint="breakpoint"
            :single-expand="singleExpand"
            :expanded.sync="expanded"
            item-key="polisa_broj"
            show-expand
            class="elevation-1 mt-2 mytable"
            :loading="isLoading"
            loading-text="Učitavanje podataka"
            hide-default-footer
            disable-pagination
          >
            <!--        Filteri-->
            <template v-slot:body.prepend>
              <tr class="grey lighten-2">
                <th
                  v-for="header in headers"
                  :key="header.name"
                  class="py-2"
                >
                  <v-text-field
                    v-if="header.value !== 'data-table-expand'"
                    v-model="filters[header.value]"
                    label="Filter"
                    :placeholder="header.text"
                    filled
                    hide-details
                    style="padding: 0; font-size: inherit; text-align: right !important;"
                    @keyup.native="searchTable"
                  />
                </th>
              </tr>
            </template>
            <!--        No data-->
            <template v-slot:no-data>
              <div class="text-center mt-5 pl-15 pr-15">
                <v-alert
                  color="error"
                  icon="mdi-alert-circle-outline"
                >
                  Nema podataka
                </v-alert>
              </div>
            </template>
            <!--        Dodati podaci za polisu-->
            <template v-slot:expanded-item="{ item }">
              <td
                :colspan="headers.length"
                class="pa-10"
              >
                <!--            Zaglavlje polise-->
                <div class="text-lg-h4">
                  <p class="text-lg-h3">
                    Sve informacije o polisi broj: <kbd>{{ item.polisa_broj }} </kbd>
                  </p>
                  <p class="text-right">
                    <b>Zamjena: </b> {{ item.zamjena }}
                  </p>
                  <p class="text-right">
                    <b>IS br. polisa: </b> {{ item.is_br_polisa }}
                  </p>
                  <p class="text-right">
                    <b>Registarska oznaka vozila: </b> {{ item.reg_oznaka_vozila }}
                  </p>
                  <p class="text-lg-h3">
                    Podaci o ugovorniku osiguranja
                  </p>
                </div>
                <v-divider />
                <!--            Podaci o ugovorniku-->
                <div class="text-lg-h4 my-3">
                  <span>
                    <b>Ime i prezime/Naziv: </b> {{ item.ime_naziv_ugovornik }}
                  </span>
                  <span class="float-right">
                    <b>JMBG/PIB: </b> {{ item.jmbg_pib_ugovornik }}
                  </span>
                </div>
                <div class="text-lg-h4 panel-footer text-center">
                  <span class="float-left">
                    <b>Grad: </b> {{ item.grad_ugovornik }}
                  </span>
                  <span>
                    <b>Ulica i broj: </b> {{ item.ulica_broj_ugovornik }}
                  </span>
                  <span class="float-right">
                    <b>Broj telefona: </b> {{ item.broj_telefona_ugovornik }}
                  </span>
                </div>
                <v-divider class="my-3" />
                <!--            Podaci o osiguraniku-->
                <p class="text-lg-h3 mt-10">
                  Podaci o osiguraniku
                </p>
                <v-divider />
                <div class="text-lg-h4 my-3">
                  <span>
                    <b>Ime i prezime/Naziv: </b> {{ item.ime_naziv_osiguranik }}
                  </span>
                  <span class="float-right">
                    <b>JMBG/PIB: </b> {{ item.jmbg_pib_osiguranik }}
                  </span>
                </div>
                <div class="text-lg-h4 panel-footer text-center">
                  <span class="float-left">
                    <b>Grad: </b> {{ item.grad_osiguranik }}
                  </span>
                  <span>
                    <b>Ulica i broj: </b> {{ item.ulica_broj_osiguranik }}
                  </span>
                  <span class="float-right">
                    <b>Broj telefona: </b> {{ item.broj_telefona_osiguranik }}
                  </span>
                </div>
                <v-divider class="my-3" />
                <!--            Podaci o vozilu-->
                <p class="text-lg-h3 mt-10">
                  Podaci o vozilu
                </p>
                <v-divider class="my-3" />
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Vrsta: </b> {{ item.vrsta }}
                  </span>
                  <span class="float-right">
                    <b>Godina proizvodnje: </b> {{ item.godina_proizvodnje }}
                  </span>
                </div>
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Marka i tip: </b> {{ item.marka_tip }}
                  </span>
                  <span class="float-right">
                    <b>Snaga KW: </b> {{ item.snaga_kw }}
                  </span>
                </div>
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Broj šasije: </b> {{ item.broj_sasije }}
                  </span>
                  <span class="float-right">
                    <b>Zapremina CCM: </b> {{ item.zapremina_ccm }}
                  </span>
                </div>
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Broj motora: </b> {{ item.broj_motora }}
                  </span>
                  <span class="float-right">
                    <b>Broj_mjesta: </b> {{ item.broj_mjesta }}
                  </span>
                </div>
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Namjena: </b> {{ item.namjena }}
                  </span>
                  <span class="float-right">
                    <b>Nosivost kg: </b> {{ item.nosivost_kg }}
                  </span>
                </div>
                <v-divider class="mt-3" />
                <!--            Podaci o trajanju-->
                <p class="text-lg-h3 mt-10">
                  Trajanje
                </p>
                <v-divider class="mt-3" />
                <p class="text-lg-h4 mt-3">
                  Osiguranje počinje u <b> {{ item.datum_od }} </b> godine u <b> {{ item.vrijeme_od }} </b> časova i traje do <b> {{ item.datum_do }} </b> godine u <b> {{ item.vrijeme_do }} </b> časova
                </p>
                <v-divider class="mt-3" />
                <!--            Podaci o premiji (porezu)-->
                <p class="text-lg-h3 mt-10">
                  Premija
                </p>
                <v-divider class="mt-3" />
                <div class="text-lg-h4 my-2">
                  <span>
                    <b>Porez: </b> {{ item.porez }}
                  </span>
                  <span class="float-right">
                    <b>Za naplatu: </b> {{ item.za_naplatu }}
                  </span>
                </div>
                <v-divider class="mt-3" />
                <!--            Sklopljeno u/dana-->
                <div class="text-lg-h4 mt-10">
                  <span>
                    <b>Sklopljeno u: </b> {{ item.sklopljeno_u }}
                  </span>
                  <span class="float-right">
                    <b>Sklopljeno dana: </b> {{ item.sklopljeno_dana }}
                  </span>
                </div>
              </td>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <p class="text-lg-h3">
      Statistika
    </p>
    <v-row>
      <v-col
        cols="12"
        sm="12"
        lg="4"
      >
        <base-material-stats-card
          color="yellow"
          icon="mdi-currency-eur"
          title="Porez"
          :value="taxCollected"
          sub-icon="mdi-bank"
          sub-text="Prikupljeno poreza u trenutnoj godini"
        />
      </v-col>

      <v-col
        cols="12"
        sm="12"
        lg="4"
      >
        <base-material-stats-card
          color="primary"
          icon="mdi-wallet"
          title="Naplata"
          :value="totalCollected"
          sub-icon="mdi-file"
          sub-text="Ukupno naplaćeno u trenutoj godini"
        />
      </v-col>

      <v-col
        cols="12"
        sm="12"
        lg="4"
      >
        <base-material-stats-card
          color="success"
          icon="mdi-file"
          title="Broj polisa"
          :value="totalNumberOfCards"
          sub-icon="mdi-card-search"
          sub-text="Broj polisa u trenutnoj godini"
        />
      </v-col>
    </v-row>
    <v-row
      align="center"
      justify="center"
      align-content-lg="center"
    >
      <v-col
        cols="12"
        sm="12"
        lg="9"
      >
        <v-card v-if="loaded">
          <v-card-title class="justify-center text-lg-h3">
            Polise iz trenutne godine ( {{ new Date().getFullYear() }} )
          </v-card-title>
          <bar-chart
            :chart-data="cardsFromThisYear"
            :chart-labels="labels"
          />
        </v-card>
      </v-col>
    </v-row>
    <v-row
      align="center"
      justify="center"
      align-content-lg="center"
    >
      <v-col
        cols="12"
        lg="9"
        md="12"
      >
        <v-card
          class="mx-auto"
        >
          <v-card-title class="justify-center">
            <span>Polise iz </span>
            <v-text-field
              v-model="yearFromInput"
              type="number"
              class="shrink ml-5 mt-5"
              label="Unesite godinu"
              solo
              @keyup.enter.native="requestDataForYear"
            />
          </v-card-title>
          <template v-if="noDataFromYearInput">
            <div class="text-center">
              <v-alert
                color="error"
                icon="mdi-alert-circle-outline"
              >
                Nema podataka
              </v-alert>
            </div>
          </template>
          <bar-chart
            v-if="loadedFromYear"
            :chart-data="cardsFromYear"
            :chart-labels="labelsFromYear"
          />
          <v-card-text v-if="loadedFromYear">
            <p class="text-lg-h3 text-center">
              Detalji o polisama za godinu {{ yearFromInput }}
            </p>
            <v-divider />
            <v-row class="text-center">
              <v-col
                cols="12"
                lg="4"
                md="12"
              >
                <p class="text-lg-h3">
                  Ukupno poreza <br> {{ taxCollectedFromYear }} <v-icon>mdi-cash</v-icon>
                </p>
              </v-col>
              <v-col
                cols="12"
                lg="4"
                md="12"
              >
                <p class="text-lg-h3">
                  Ukupno naplaćeno <br> {{ totalCollectedFromYear }} <v-icon>mdi-wallet</v-icon>
                </p>
              </v-col>
              <v-col
                cols="12"
                lg="4"
                md="12"
              >
                <p class="text-lg-h3">
                  Broj polisa <br>{{ totalNumberOfCardsFromYear }} <v-icon>mdi-file</v-icon>
                </p>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import BarChart from './components/core/CardsChart.vue'
  import axios from 'axios'
  import {
    searchTable,
  } from '../../methods/Methods'

  export default {
    name: 'DashboardDashboard',
    components: { BarChart },
    data () {
      return {
        taxCollected: 'No data',
        totalCollected: 'No data',
        totalNumberOfCards: 'No data',
        cardsFromThisYear: [],
        cardsFromYear: [],
        yearFromInput: '',
        nextDaysFromInput: '',
        noDataFromYearInput: false,
        loaded: false,
        loadedFromYear: false,
        labels: [],
        labelsFromYear: [],
        breakpoint: 400,
        isLoading: false,
        expanded: [],
        singleExpand: true,
        headers: [
          {
            text: 'Polisa broj',
            align: 'start',
            value: 'polisa_broj',
          },
          { text: 'Reg. oznaka vozila', value: 'reg_oznaka_vozila' },
          { text: 'Ugovornik', value: 'ime_naziv_ugovornik' },
          { text: 'Osiguranik', value: 'ime_naziv_osiguranik' },
          { text: 'Vozilo', value: 'marka_tip' },
          { text: 'Datum od', value: 'datum_od' },
          { text: 'Datum do', value: 'datum_do' },
          { text: '', value: 'data-table-expand' },
        ],
        cardsInNextDays: [],
        tableData: [],
        filteredTableData: [],
        filters: [],
        taxCollectedFromYear: 'No data',
        totalCollectedFromYear: 'No data',
        totalNumberOfCardsFromYear: 'No data',
      }
    },
    mounted () {
      if (this.$auth.isAuthenticated()) {
        this.requestDataForCurrentYear()
        this.getTaxCollectedForCurrentYear()
        this.getTotalCollectedForCurrentYear()
        this.getTotalNumberOfCardsForCurrentYear()
      }
    },
    methods: {
      requestDataForCurrentYear () {
        axios
          .get('/api/cardsFromThisYear')
          .then(response => {
            this.cardsFromThisYear = response.data.map(entry => entry.number_of_cards)
            this.labels = response.data.map(entry => entry.month)
            this.loaded = true
          })
          .catch(error => {
            this.loaded = false
            alert(error)
          })
      },
      requestDataForYear () {
        this.loadedFromYear = false
        this.noDataFromYearInput = false
        this.cardsFromYear = []
        this.labelsFromYear = []
        if (this.yearFromInput !== '') {
          axios
            .get(`/api/cardsFrom/${this.yearFromInput}`)
            .then(response => {
              if (response.data.length === 0) {
                this.noDataFromYearInput = true
                this.loadedFromYear = false
                this.cardsFromYear = []
                this.labelsFromYear = []
              } else {
                this.noDataFromYearInput = false
                this.cardsFromYear = response.data.map(entry => entry.number_of_cards)
                this.labelsFromYear = response.data.map(entry => entry.month)
                this.loadedFromYear = true
              }
            })
            .catch(error => {
              this.cardsFromYear = []
              this.labelsFromYear = []
              this.loadedFromYear = false
              alert(error)
            })
        }
        this.getTaxCollectedForYear()
        this.getTotalCollectedForYear()
        this.getTotalNumberOfCardsForYear()
      },
      getTaxCollectedForCurrentYear () {
        axios
          .get('/api/tax')
          .then(response => {
            this.taxCollected = response.data + ' €'
          })
          .catch(error => {
            alert(error)
          })
      },
      getTotalCollectedForCurrentYear () {
        axios
          .get('/api/totalCollected')
          .then(response => {
            this.totalCollected = response.data + ' €'
          })
          .catch(error => {
            alert(error)
          })
      },
      getTotalNumberOfCardsForCurrentYear () {
        axios
          .get('/api/totalCards')
          .then(response => {
            this.totalNumberOfCards = response.data + ''
          })
          .catch(error => {
            alert(error)
          })
      },
      getCardsInNextDays () {
        this.isLoading = true
        if (this.nextDaysFromInput !== '') {
          axios
            .get(`/api/cardsInNext/${this.nextDaysFromInput}`)
            .then(response => {
              this.tableData = response.data
              this.isLoading = false
            })
            .catch(error => {
              alert(error)
            })
        } else {
          this.isLoading = false
          this.tableData = []
        }
      },
      searchTable,
      getTaxCollectedForYear () {
        axios
          .get(`/api/tax/${this.yearFromInput}`)
          .then(response => {
            this.taxCollectedFromYear = response.data + ' €'
          })
          .catch(error => {
            alert(error)
          })
      },
      getTotalCollectedForYear () {
        axios
          .get(`/api/totalCollected/${this.yearFromInput}`)
          .then(response => {
            this.totalCollectedFromYear = response.data + ' €'
          })
          .catch(error => {
            alert(error)
          })
      },
      getTotalNumberOfCardsForYear () {
        axios
          .get(`/api/totalCards/${this.yearFromInput}`)
          .then(response => {
            this.totalNumberOfCardsFromYear = response.data + ''
          })
          .catch(error => {
            alert(error)
          })
      },
      isLoggedIn () {
        if (!this.$auth.isAuthenticated()) {
          this.$router.push('/login')
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
