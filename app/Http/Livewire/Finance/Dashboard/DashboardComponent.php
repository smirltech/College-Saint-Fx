<?php

namespace App\Http\Livewire\Finance\Dashboard;


use App\Helpers\Helpers;
use App\Models\Annee;
use App\Models\Depense;
use App\Models\Perception;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Pharaonic\Laravel\Readable\Readable;

class DashboardComponent extends Component
{
    use TopMenuPreview;

    public $dayCount = 30;
    public $boxes = [];
    private $anneeEncours;

    public function mount(): void
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }
        //Annee::class

        $this->anneeEncours = Annee::encours();


        $monthTo = Carbon::now()->endOfMonth();
        $monthFrom = $monthTo->copy()->subMonth()->subDay()->addSecond();

        //dd("$monthFrom === $monthTo");

        // todo: we should consider annee_id wh en fetching data
        $revenuTotalSum = Revenu::where('annee_id', $this->anneeEncours->id)->sum("montant");
        $revenuMonthSum = Perception::paid()/*->whereBetween('created_at', [$monthFrom, $monthTo])*/ ->sum("montant");
        $rateRevenuMonth = $revenuTotalSum <= 0 ? 0 : intval($revenuMonthSum / $revenuTotalSum * 100);

        $depenseTotalSum = Depense::where('annee_id', $this->anneeEncours->id)->sum("montant");
        $depenseMonthSum = Depense::where('annee_id', $this->anneeEncours->id)->whereBetween('created_at', [$monthFrom, $monthTo])->sum("montant");
        $rateDepenseMonth = $depenseTotalSum <= 0 ? 0 : intval($depenseMonthSum / $depenseTotalSum * 100);

        $perceptionsRequest = Perception::where('annee_id', $this->anneeEncours->id);
        $perceptions = $perceptionsRequest->get();
        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");
        $perceptionSold = $perceptionsDues - $perceptionsPaid;
        $ratePerceptionSold = $perceptionsDues <= 0 ? 0 : intval($perceptionSold / $perceptionsDues * 100);


        $this->boxes = [
            [
                'title' => '$ ' . Readable::getHumanNumber($depenseMonthSum, showDecimal: true, decimals: 2),// Helpers::currencyFormat($depenseMonthSum, symbol: 'Fc'),
                'text' => 'Dépenses',
                'icon' => 'far fa-money-bill-alt',
                'url' => "#",
                'theme' => 'danger',
                'rate' => "{$rateDepenseMonth}%",
                'subtitle' => "+{$rateDepenseMonth}% en 1 mois",

            ],
            [
                'title' => '$ ' . Readable::getHumanNumber($perceptionSold, showDecimal: true, decimals: 2),
                'text' => 'Frais impayées',
                'icon' => 'fas fa-money-bill-wave',
                'url' => "#",
                'theme' => 'primary',
                'rate' => "{$ratePerceptionSold}%",
                'subtitle' => "de " . Helpers::currencyFormat($perceptionsDues, symbol: 'Fc') . " cette année scolaire",
            ],
            [
                'title' => number_format(($perceptionsPaid / $perceptionsDues) * 100) . '%',
                'text' => 'Taux recouvrement',
                'icon' => 'far fa-bookmark',
                'url' => "scolarite/inscriptions/status/rejected",
                'theme' => 'warning',
                'rate' => "45%",
                'subtitle' => "+45% en 1 mois",
            ],
            [
                'title' => '$ ' . Readable::getHumanNumber($revenuMonthSum, showDecimal: true, decimals: 2),
                'text' => 'Perceptions',
                'icon' => 'far fa-bookmark',
                'url' => "",
                'theme' => 'success',
                'rate' => "{$rateRevenuMonth}%",
                'subtitle' => "+{$rateRevenuMonth}% en 1 mois",
            ]
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.finance.dashboard.dashboard')
            ->layout(AdminLayout::class, ['title' => 'Admin Dashboard']);
    }

}
