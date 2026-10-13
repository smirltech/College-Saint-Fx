<?php

namespace SmirlTech\LaravelMedia\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use SmirlTech\LaravelMedia\Models\Media;

class GalleryComponent extends Component
{

    public Collection $images;

    public function mount(?string $model_type, null|int|string $model_id): void
    {
        if ($model_id && $model_type) {
            $model = $model_type::find($model_id);
            $this->images = $model->media()->images()->get();
        } else {
            $this->images = Media::images()->get();
        }
    }

    public function render(): Factory|View|Application
    {
        return view('media::livewire.gallery-component');
    }

    public function delete($id): void
    {
        $image = Media::find($id);
        $image->delete();
    }


    public function setMain($id): void
    {
        $image = Media::find($id);
        $image->makeMainImage();
    }
}
