<template>
  <v-container
    v-if="isLoggedIn()"
    id="regular-tables"
    fluid
    tag="section"
  >
    <v-card>
      <v-card-title class="pt-5 pb-5">
        Informacije o polisama
      </v-card-title>
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
        :footer-props="{itemsPerPageText: 'Broj redova'}"
      >
        <!--        Filteri-->
        <template v-slot:body.prepend>
          <tr class="grey lighten-2">
            <th
              v-for="header in headers"
              :key="header.name"
              class="py-3"
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
              icon="mdi-alert-circle"
            >
              Nema podataka
            </v-alert>
          </div>
        </template>
        <!--        Dodati podaci za polisu-->
        <template v-slot:expanded-item="{item }">
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
  </v-container>
</template>

<script>

  import axios from 'axios'
  import {
    searchTable,
  } from '../../../methods/Methods'

  export default {
    name: 'Vozila',
    data () {
      return {
        breakpoint: 500,
        isLoading: true,
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
        cards: [],
        tableData: [],
        filteredTableData: [],
        filters: [],
      }
    },
    mounted () {
      axios
        .get('/api/cards')
        .then(response => {
          this.cards = response.data
          this.tableData = response.data
          this.isLoading = false
        })
        .catch(error => {
          alert(error)
        })
    },
    methods: {
      searchTable,
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
