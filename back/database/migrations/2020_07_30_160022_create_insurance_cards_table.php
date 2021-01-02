<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_cards', function (Blueprint $table) {
            $table->bigIncrements('id');

            // zaglavlje polise
            $table->string('polisa_broj')->unique();
            $table->string('zamjena')->nullable();
            $table->string('is_br_polisa')->nullable();
            $table->string('reg_oznaka_vozila');

            // podaci o ugovorniku osiguranja
            $table->string('ime_naziv_ugovornik');
            $table->string('jmbg_pib_ugovornik');
            $table->string('grad_ugovornik');
            $table->string('ulica_broj_ugovornik');
            $table->string('br_tel_ugovornik')->nullable();

            // podaci o osiguraniku
            $table->string('ime_naziv_osiguranik');
            $table->string('jmbg_pib_osiguranik');
            $table->string('grad_osiguranik');
            $table->string('ulica_broj_osiguranik');
            $table->string('br_tel_osiguranik')->nullable();

            // podaci o vozilu
            $table->string('vrsta');
            $table->string('marka_tip');
            $table->string('broj_sasije');
            $table->string('broj_motora')->nullable();
            $table->string('namjena')->nullable();
            $table->year('godina_proizvodnje')->unsigned();
            $table->integer('snaga_kw')->unsigned()->nullable();
            $table->integer('zapremina_ccm')->unsigned()->nullable();
            $table->integer('broj_mjesta')->unsigned()->nullable();
            $table->integer('nosivost_kg')->unsigned()->nullable();


            // trajanje osiguranja
            $table->date('datum_od');
            $table->time('vrijeme_od');
            $table->date('datum_do');
            $table->time('vrijeme_do');


            //autoodgovornost
            $table->string('tar_grupa')->nullable();
            $table->string('tar_podgrupa')->nullable();
            $table->string('osnovna_premija')->nullable();
            $table->string('prem_razred')->nullable();
            $table->string('doplatak_popust')->nullable();
            $table->string('premija')->nullable();

            // prosiranje osiguravajuceg pokrica
            $table->longText('napomena')->nullable();

            // PREMIJA
            $table->decimal('porez', 20, 2)->nullable();
            $table->decimal('za_naplatu', 20, 2)->nullable();
            $table->decimal('svega', 20, 2)->nullable();

            // donji dio polise
            $table->string('osiguravac_ime_prezime')->nullable();
            $table->string('sifra')->nullable();
            $table->string('br_ovlascenja')->nullable();
            $table->string('sklopljeno_u');
            $table->date('sklopljeno_dana');

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_cards');
    }
}
