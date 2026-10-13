<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\Devise;
use App\Enums\FraisType;
use App\Enums\MinervalMonth;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Frais;
use App\Models\Perception;
use Exception;
use Illuminate\Support\Optional;
use Rap2hpoutre\FastExcel\FastExcel;

class PerceptionImport
{
    public function __construct(
        private readonly Frais  $frais,
        private readonly Annee  $annee,
        private readonly Devise $devise,
    )
    {
    }

    // build
    public static function build(
        Frais  $frais,
        Annee  $annee,
        Devise $devise,
    ): self
    {
        return new self(
            frais: $frais,
            annee: $annee,
            devise: $devise
        );
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        (new FastExcel)->import($file, function ($line) {
            $line = optional((array_change_key_case($line)));

            $nom = $line['nom'] ?? null;

            if ($nom) {
                $eleve = Eleve::where('nom', trim($nom))->first();


                $inscription = $eleve?->inscription;

                if ($inscription) {


                    $create = true;
                    // skip if section is not the same as the selected section or option is not the same as the selected option, but not if both are null
                    if ($this->frais->section && $inscription->section?->code != $this->frais->section) {
                        $create = false;
                    }

                    if ($this->frais->option_id && $inscription->option?->id != $this->frais->option_id) {
                        $create = false;
                    }

                    if ($create) {
                        if ($this->frais->type == FraisType::MINERVAL) {
                            $this->createMinerval(
                                eleve: $eleve,
                                frais: $this->frais,
                                line: $line,
                            );
                        } else {
                            // if check line has cdf or usd values then create perception
                            if ($line['montant'] > 0) {
                                $this->create(
                                    eleve: $eleve,
                                    frais: $this->frais,
                                    line: $line,
                                );
                            }
                        }
                    }
                } else {
                    throw new Exception("L'élève {$nom} n'est pas inscrit dans une classe");
                }
            }
        });
    }

    public function createMinerval(
        Eleve    $eleve,
        Frais    $frais,
        Optional $line,
    ): void
    {
        foreach (MinervalMonth::cases() as $month) {
            if ($line[$month->value]) {
                $devise = $line[$month->value] >= 1000 ? Devise::CDF : Devise::USD;

                $p = Perception::updateOrCreate([
                    'inscription_id' => $eleve->inscription->id,
                    'custom_property' => $month->value,
                ], [
                    'frais_id' => $frais->id,
                    'montant' => $line[$month->value],
                    'taux' => $devise == Devise::CDF ? 2900 : null,
                    'frais_montant' => $frais->montant,
                    'devise' => $devise,
                ]);
            }
        }
    }

    public function create(
        Eleve    $eleve,
        Frais    $frais,
        Optional $line,
    ): void
    {
        $devise = $line['montant'] >= 1000 ? Devise::CDF : Devise::USD;

        Perception::updateOrCreate([
            'inscription_id' => $eleve->inscription->id,
            'frais_id' => $frais->id,
        ], [
            'montant' => $line['montant'],
            'frais_montant' => $frais->montant,
            'taux' => $devise == Devise::CDF ? 2900 : null,
            'devise' => $devise,
        ]);
    }
}
