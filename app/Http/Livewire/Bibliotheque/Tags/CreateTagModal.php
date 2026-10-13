<?php

namespace App\Http\Livewire\Bibliotheque\Tags;

use App\Models\Tag;
use App\Traits\HasLivewireAlert;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateTagModal extends Component
{
    public Tag $etiquette;
    public ?string $etiquette_name;

    use HasLivewireAlert;


    public function mount(Tag $etiquette): void
    {
        $this->etiquette = $etiquette;
        $this->etiquette_name = $etiquette->name;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.tags.create-tag-modal');
    }

    // submit()
    public function submit(): void
    {
        $this->validate();

        $this->etiquette->name = $this->etiquette_name;
        $this->etiquette->save();

        $this->emit('hideModal');
        $this->emit('refresh');


        $this->success("Étiquette modifiée avec succès !");

    }

    // rules()
    public function rules(): array
    {
        return [
            'etiquette_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags', 'name->fr')->ignore($this->etiquette->id),
            ],
        ];
    }
}
