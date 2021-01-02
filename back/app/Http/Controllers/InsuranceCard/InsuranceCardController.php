<?php

namespace App\Http\Controllers\InsuranceCard;

use App\Http\Controllers\Controller;
use App\InsuranceCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsuranceCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InsuranceCard::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'polisa_broj' => 'required|unique:insurance_cards',
            'zamjena' => 'nullable',
            'is_br_polisa' => 'nullable',
            'reg_oznaka_vozila' => 'required',

            'ime_naziv_ugovornik' => 'required',
            'jmbg_pib_ugovornik' => 'required',
            'grad_ugovornik' => 'required',
            'ulica_broj_ugovornik' => 'required',
            'br_tel_ugovornik' => 'nullable',

            'ime_naziv_osiguranik' => 'required',
            'jmbg_pib_osiguranik' => 'required',
            'grad_osiguranik' => 'required',
            'ulica_broj_osiguranik' => 'required',
            'br_tel_osiguranik' => 'nullable',

            'vrsta' => 'required',
            'marka_tip' => 'required',
            'broj_sasije' => 'required',
            'broj_motora' => 'nullable',
            'namjena' => 'nullable',
            'godina_proizvodnje' => 'required',
            'snaga_kw' => 'nullable',
            'zapremina_ccm' => 'nullable',
            'broj_mjesta' => 'nullable',
            'nosivost_kg' => 'nullable',

            'datum_od' => 'required|date',
            'datum_do' => 'required|date',
            'vrijeme_od' => 'required',
            'vrijeme_do' => 'required',

            'tar_grupa' => 'nullable',
            'tar_podgrupa' => 'nullable',
            'osnovna_premija' => 'nullable',
            'prem_razred' => 'nullable',
            'doplatak_popust' => 'nullable',
            'premija' => 'nullable',

            'napomena' => 'nullable',

            'porez' => 'nullable',
            'za_naplatu' => 'nullable',
            'svega' => 'nullable',
            'osiguravac_ime_prezime' => 'nullable',
            'sifra' => 'nullable',
            'br_ovlascenja' => 'nullable',
            'sklopljeno_u' => 'nullable',
            'sklopljeno_dana' => 'nullable',
        ]);


        $insuranceCard = InsuranceCard::create([
            'polisa_broj' => $request->polisa_broj,
            'zamjena' => $request->zamjena,
            'is_br_polisa' => $request->is_br_polisa,
            'reg_oznaka_vozila' => $request->reg_oznaka_vozila,

            'ime_naziv_ugovornik' => $request->ime_naziv_ugovornik,
            'jmbg_pib_ugovornik' => $request->jmbg_pib_ugovornik,
            'grad_ugovornik' => $request->grad_ugovornik,
            'ulica_broj_ugovornik' => $request->ulica_broj_ugovornik,
            'br_tel_ugovornik' => $request->br_tel_ugovornik,

            'ime_naziv_osiguranik' => $request->ime_naziv_osiguranik,
            'jmbg_pib_osiguranik' => $request->jmbg_pib_osiguranik,
            'grad_osiguranik' => $request->grad_osiguranik,
            'ulica_broj_osiguranik' => $request->ulica_broj_osiguranik,
            'br_tel_osiguranik' => $request->br_tel_osiguranik,

            'vrsta' => $request->vrsta,
            'marka_tip' => $request->marka_tip,
            'broj_sasije' => $request->broj_sasije,
            'broj_motora' => $request->broj_motora,
            'namjena' => $request->namjena,
            'godina_proizvodnje' => $request->godina_proizvodnje,
            'snaga_kw' => $request->snaga_kw,
            'zapremina_ccm' => $request->zapremina_ccm,
            'broj_mjesta' => $request->broj_mjesta,
            'nosivost_kg' => $request->nosivost_kg,

            'datum_od' => $request->datum_od,
            'datum_do' => $request->datum_do,
            'vrijeme_od' => $request->vrijeme_od,
            'vrijeme_do' => $request->vrijeme_do,

            'tar_grupa' => $request->tar_grupa,
            'tar_podgrupa' => $request->tar_podgrupa,
            'osnovna_premija' => $request->osnovna_premija,
            'prem_razred' => $request->prem_razred,
            'doplatak_popust' => $request->doplatak_popust,
            'premija' => $request->premija,

            'napomena' => $request->napomena,

            'porez' => $request->porez,
            'za_naplatu' => $request->za_naplatu,
            'svega' => $request->svega,
            'osiguravac_ime_prezime' => $request->osiguravac_ime_prezime,
            'sifra' => $request->sifra,
            'br_ovlascenja' => $request->br_ovlascenja,
            'sklopljeno_u' => $request->sklopljeno_u,
            'sklopljeno_dana' => $request->sklopljeno_dana,
        ]);

        return InsuranceCard::find($insuranceCard->id);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InsuranceCard::findOrFail($id);
    }

/*    public function insuranceCardGeneralInfo()
    {
        return DB::table('insurance_cards')
            ->join('contractors', 'insurance_cards.id', 'contractors.insurance_card_id')
            ->join('insureds', 'insurance_cards.id', 'insureds.insurance_card_id')
            ->join('cars', 'insurance_cards.id', 'cars.insurance_card_id')
//            ->select('insurance_cards.polisa_broj', 'insurance_cards.reg_oznaka_vozila', 'contractors.ime_naziv as ugovarac', 'insureds.ime_naziv as osiguranik')
            ->select('insurance_cards.polisa_broj', 'insurance_cards.reg_oznaka_vozila', 'contractors.ime_naziv as ugovarac', 'insureds.ime_naziv as osiguranik', 'cars.marka_tip as vozilo')
            ->whereMonth('insurance_cards.datum_od', '>=', '2')
            ->get();


    }*/

    public function getCardsInNextDays()
    {
        print_r(Carbon::now());
        return DB::table('insurance_cards')
            ->whereDate('datum_do', Carbon::now()->subDays(15))
            ->get();

    }

    public function getCardsInNext($days)
    {
        $today = Carbon::today();
        $from = Carbon::today();
        $to = $from->addDays($days);

        return InsuranceCard::whereBetween('datum_do',[$today,$to])
            ->get();

    }

    public function getContractors()
    {
        return DB::table('insurance_cards')
            ->select('ime_naziv_ugovornik', 'jmbg_pib_ugovornik', 'grad_ugovornik', 'ulica_broj_ugovornik', 'br_tel_ugovornik')
            ->distinct()
            ->get();

    }

    public function getContractor($name)
    {


        return DB::table('insurance_cards')
            ->select('ime_naziv_ugovornik', 'jmbg_pib_ugovornik', 'grad_ugovornik', 'ulica_broj_ugovornik', 'br_tel_ugovornik')
            ->where('ime_naziv_ugovornik', 'like', '%' . $name . '%')
            ->limit(1)
            ->get();
    }

    public function getInsureds()
    {
        return DB::table('insurance_cards')
            ->select('ime_naziv_osiguranik', 'jmbg_pib_osiguranik', 'grad_osiguranik', 'ulica_broj_osiguranik', 'br_tel_osiguranik')
            ->distinct()
            ->get();
    }

    public function getInsured($name)
    {


        return DB::table('insurance_cards')
            ->select('ime_naziv_osiguranik', 'jmbg_pib_osiguranik', 'grad_osiguranik', 'ulica_broj_osiguranik', 'br_tel_osiguranik')
            ->where('ime_naziv_osiguranik', 'like', '%' . $name . '%')
            ->limit(1)
            ->get();
    }

    public function getCars()
    {
        return DB::table('insurance_cards')
            ->select('reg_oznaka_vozila', 'vrsta', 'marka_tip', 'broj_sasije', 'broj_motora', 'namjena', 'godina_proizvodnje', 'snaga_kw', 'zapremina_ccm', 'broj_mjesta', 'nosivost_kg')
            ->distinct('broj_sasije')
            ->get();
    }

    public function getStatsFromCurrentYear(){

        return InsuranceCard::whereYear('datum_od', Carbon::now()->year)
            ->select(DB::raw('MONTHNAME(datum_od) month'),DB::raw("count('month') as number_of_cards"))
            ->groupby('month')
            ->orderby(DB::raw("FIELD(month,'January','February','March','April','May','June','July','August','September','October','November','December')"))
            ->get();

    }

    public function getStatsFromYear($year){

        return InsuranceCard::whereYear('datum_od', $year)
            ->select(DB::raw('MONTHNAME(datum_od) month'),DB::raw("count('month') as number_of_cards"))
            ->groupby('month')
            ->orderby(DB::raw("FIELD(month,'January','February','March','April','May','June','July','August','September','October','November','December')"))
            ->get();

    }

    public function getTaxFromCurrentYear(){

        $tax = DB::table('insurance_cards')
            ->whereYear('datum_od', Carbon::now()->year)
            ->sum('porez');

        return $tax;

    }

    public function getTotalCollectedFromCurrentYear(){

        $totalCollected = DB::table('insurance_cards')
            ->whereYear('datum_od', Carbon::now()->year)
            ->sum('za_naplatu');

        return $totalCollected;

    }

    public function getTotalCardsFromCurrentYear(){

        $totalCards = InsuranceCard::whereYear('datum_od', Carbon::now()->year)->count();

        return $totalCards;

    }

    public function getTaxFromYear($year){

        $tax = DB::table('insurance_cards')
            ->whereYear('datum_od', $year)
            ->sum('porez');

        return $tax;

    }

    public function getTotalCollectedFromYear($year){

        $totalCollected = DB::table('insurance_cards')
            ->whereYear('datum_od', $year)
            ->sum('za_naplatu');

        return $totalCollected;

    }

    public function getTotalCardsFromYear($year){

        $totalCards = InsuranceCard::whereYear('datum_od', $year)->count();

        return $totalCards;

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
