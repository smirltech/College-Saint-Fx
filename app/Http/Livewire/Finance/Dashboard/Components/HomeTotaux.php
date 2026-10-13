<?php

namespace App\Http\Livewire\Finance\Dashboard\Components;

use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Models\Annee;
use App\Models\Depense;
use App\Models\Paiment;
use App\Models\Perception;
use App\Models\Revenu;
use Carbon\Carbon;
use Livewire\Component;

class HomeTotaux extends Component
{
    public $annee_id;
    public $dayCount = 15;
    public $dateDebut;
    public $dateFin;

    // Frais
    public $totalPerceptions;
    public $changePerceptions;
    public $changeSignPerceptions;

    // Revenus
    public $totalRevenus;
    public $changeRevenus;
    public $changeSignRevenus;

    // Depenses
    public $totalDepenses;
    public $changeDepenses;
    public $changeSignDepenses;

    // Solde
    public $totalSolde;
    public $changeSolde;
    public $changeSignSolde;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($dayCount = 7)
    {

        $this->dayCount = $dayCount;
        $this->annee_id = Annee::encours()->id;

        $tdate = Carbon::now();
        $sdate = Carbon::now()->startOfMonth();
        $mdate = Carbon::now()->startOfMonth()->subMonth();

        //Perceptions
        $this->totalPerceptions = Perception::where('annee_id', $this->annee_id)->sum('montant');
        $sPerceptions = Perception::where('annee_id', $this->annee_id)->sum('paid');
        $this->changePerceptions = $this->totalPerceptions == 0 ? 100 : (int)($sPerceptions / $this->totalPerceptions * 100);
        if ($this->changePerceptions < 0) {
            $this->changeSignPerceptions = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else if ($this->changePerceptions > 0) {
            $this->changeSignPerceptions = [
                'text' => 'success',
                'caret' => 'up'
            ];
        } else {
            $this->changeSignPerceptions = [
                'text' => 'warning',
                'caret' => 'left'
            ];
        }


        //Revenus
        $this->totalRevenus = Revenu::where('annee_id', $this->annee_id)->sum('montant');
        $this->totalRevenus += Perception::where('annee_id', $this->annee_id)->sum('paid');
        $sMonthRevenus = Revenu::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $sdate)->whereDate("created_at", "<=", $tdate)->sum('montant');
        $sMonthRevenus += Perception::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $sdate)->whereDate("created_at", "<=", $tdate)->sum('paid');
        $mMonthRevenus = Revenu::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $mdate)->whereDate("created_at", "<", $sdate)->sum('montant');
        $mMonthRevenus += Perception::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $mdate)->whereDate("created_at", "<", $sdate)->sum('paid');
        $this->changeRevenus = $mMonthRevenus == 0 ? 100 : (int)($sMonthRevenus / $mMonthRevenus * 100);
        if ($this->changeRevenus < 0) {
            $this->changeSignRevenus = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else if ($sMonthRevenus - $mMonthRevenus > 0) {
            $this->changeSignRevenus = [
                'text' => 'success',
                'caret' => 'up'
            ];
        } else if ($sMonthRevenus - $mMonthRevenus < 0) {
            $this->changeSignRevenus = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else {
            $this->changeSignRevenus = [
                'text' => 'warning',
                'caret' => 'left'
            ];
        }

        //Depenses
        $this->totalDepenses = Depense::where('annee_id', $this->annee_id)->sum('montant');
        $this->totalDepenses += Paiment::where('annee_id', $this->annee_id)->sum('montant');
        $sMonthDepenses = Depense::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $sdate)->whereDate("created_at", "<=", $tdate)->sum('montant');
        $sMonthDepenses += Paiment::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $sdate)->whereDate("created_at", "<=", $tdate)->sum('montant');
        $mMonthDepenses = Depense::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $mdate)->whereDate("created_at", "<", $sdate)->sum('montant');
        $mMonthDepenses += Paiment::where('annee_id', $this->annee_id)->whereDate("created_at", ">=", $mdate)->whereDate("created_at", "<", $sdate)->sum('montant');
        $this->changeDepenses = $mMonthDepenses == 0 ? 100 : (int)($sMonthDepenses / $mMonthDepenses * 100);
        if ($this->changeDepenses < 0) {
            $this->changeSignDepenses = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else if ($sMonthDepenses - $mMonthDepenses > 0) {
            $this->changeSignDepenses = [
                'text' => 'success',
                'caret' => 'up'
            ];
        } else if ($sMonthDepenses - $mMonthDepenses < 0) {
            $this->changeSignDepenses = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else {
            $this->changeSignDepenses = [
                'text' => 'warning',
                'caret' => 'left'
            ];
        }

        // Solde
        $this->totalSolde = $this->totalRevenus - $this->totalDepenses;
        // dd($this->totalSolde);
        $sMonthSolde = $sMonthRevenus - $sMonthDepenses;
        $mMonthSolde = $mMonthRevenus - $mMonthDepenses;
        //dd($mMonthSolde);
        $this->changeSolde = $mMonthSolde == 0 ? 100 : (int)($sMonthSolde / $mMonthSolde * 100);
        if ($this->changeSolde < 0) {
            $this->changeSignSolde = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else if ($sMonthSolde - $mMonthSolde > 0) {
            $this->changeSignSolde = [
                'text' => 'success',
                'caret' => 'up'
            ];
        } else if ($sMonthSolde - $mMonthSolde < 0) {
            $this->changeSignSolde = [
                'text' => 'danger',
                'caret' => 'down'
            ];
        } else {
            $this->changeSignSolde = [
                'text' => 'warning',
                'caret' => 'left'
            ];
        }

    }

    public function render()
    {
        return view('livewire.finance.dashboard.components.home-totaux');
    }
}

