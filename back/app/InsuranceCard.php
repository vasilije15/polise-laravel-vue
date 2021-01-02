<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceCard extends Model
{
    protected $fillable = [
        'id',
        'polisa_broj',
        'zamjena',
        'is_br_polisa',
        'reg_oznaka_vozila',

        'ime_naziv_ugovornik',
        'jmbg_pib_ugovornik',
        'grad_ugovornik',
        'ulica_broj_ugovornik',
        'br_tel_ugovornik',

        'ime_naziv_osiguranik',
        'jmbg_pib_osiguranik',
        'grad_osiguranik',
        'ulica_broj_osiguranik',
        'br_tel_osiguranik',

        'vrsta',
        'marka_tip',
        'broj_sasije',
        'broj_motora',
        'namjena',
        'godina_proizvodnje',
        'snaga_kw',
        'zapremina_ccm',
        'broj_mjesta',
        'nosivost_kg',

        'datum_od',
        'datum_do',
        'vrijeme_od',
        'vrijeme_do',

        'tar_grupa',
        'tar_podgrupa',
        'osnovna_premija',
        'prem_razred',
        'doplatak_popust',
        'premija',

        'napomena',

        'porez',
        'za_naplatu',
        'svega',
        'osiguravac_ime_prezime',
        'sifra',
        'br_ovlascenja',
        'sklopljeno_u',
        'sklopljeno_dana',


    ];


}
