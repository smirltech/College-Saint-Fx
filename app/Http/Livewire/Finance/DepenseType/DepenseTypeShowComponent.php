<?php

namespace App\Http\Livewire\Finance\DepenseType;

use App\Http\Livewire\BaseComponent;
use App\Models\DepenseType;
use App\Models\Option;
use App\Models\Section;
use App\Traits\OptionCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DepenseTypeShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;


    public DepenseType $depenseType;


    public function mount(DepenseType $depenseType)
    {
        $this->authorize("view", $depenseType);
        $this->depenseType = $depenseType;
    }


    public function loadData()
    {

    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses_types.show')
            ->layout(AdminLayout::class);
    }

}
