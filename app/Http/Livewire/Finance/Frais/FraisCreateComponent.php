<?php

namespace App\Http\Livewire\Finance\Frais;

use App\Enums\Devise;
use App\Enums\FraisType;
use App\Enums\Section;
use App\Http\Livewire\BaseComponent;
use App\Models\Eleve;
use App\Models\Option;
use App\Models\Frais;
use App\Traits\HasLivewireAlert;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class FraisCreateComponent extends BaseComponent
{

    use HasLivewireAlert;

    public Frais $fee;
    public ?FraisType $type;


    public string $title = "Create Fee";

    public function mount(Frais $fee): void
    {
        $this->fee = $fee;
        $this->types = FraisType::cases();
        $this->sections = Section::cases();
        $this->options = Option::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.frais.frais-create-component');
    }

    public function rules(): array
    {
        return [
            'fee.nom' => ['required', 'string', 'max:255', 'unique:frais,nom,' . $this->fee->id],
            'fee.montant' => ['required'],
            'fee.devise' => ['required'],
            'fee.type' => ['required'],
            'fee.sub_type' => ['nullable'],
            'fee.option_id' => ['nullable'],
            'fee.section' => ['nullable'],

        ];
    }




//    public function mount(Frais $fee): void
//    {
//        $this->fee = $fee;
//        if ($fee->exists) {
//            $this->title = "Update Fee";
//        } else {
//            $this->title = "Create Fee";
//            $this->fee = new Frais;
//        }
//
//    }

//    public function render(): Factory|\Illuminate\Foundation\Application|View|\Illuminate\Contracts\Foundation\Application
//    {
//
//        return view('livewire.finance.frais.create_update-frais', [
//            'facultes' => Faculte::all(),
//            'grades' => PromotionNiveau::cases(),
//            'currencies' => Devise::cases(),
//            'types' => FraisType::cases(),
//        ]);
//    }

    public function submit(): void
    {
        $this->validate();

        $this->fee->save();

        if ($this->fee->wasRecentlyCreated) {
            $this->flashSuccess(
                __('Fee successfully created.'),
                route('finance.frais')
            );
        } else {
            $this->flashSuccess(
                __('Fee successfully updated.'),
                route('finance.frais')
            );
        }
    }

    public function updatedFeeType(): void
    {
        $this->fee->sub_type = null;
        $this->generateFeeName();
    }

    public function updatedFeeSubType(): void
    {
        $this->generateFeeName();
    }

    public function updatedFeeOptionId(): void
    {
        $this->generateFeeName();
    }

    public function updatedFeeSection(): void
    {
        $this->fee->option_id = null;
        $this->generateFeeName();
    }

    public function generateFeeName(): void
    {
        $this->fee->nom = null;
        if ($this->fee->type == FraisType::AUTRE) return;

        $type = $this->fee->type?->label();
        $section = $this->fee->section ?: null;
        $option = $this->fee->option_id ? Option::find($this->fee->option_id)->code : null;

        $this->fee->nom = trim(Str::replace(
            search: '  ',
            replace: ' ',
            subject: Str::upper("$type {$this->fee->sub_type} {$section} {$option}")
        ));
    }
}
