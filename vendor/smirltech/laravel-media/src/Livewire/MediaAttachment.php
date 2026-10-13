<?php

namespace SmirlTech\LaravelMedia\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithFileUploads;

class MediaAttachment extends Component
{
    use WithFileUploads;

    public mixed $media = [];
    /**
     * @var mixed|string
     */
    private mixed $collection;
    private mixed $model;
    private mixed $rules;

    public function render(): Factory|View|Application
    {
        return view('media::livewire.media-attachment');
    }

    #[NoReturn] public function mount(mixed $model, string $rules = 'max:1024', mixed $collection = 'default')
    {
        $this->model = $model;
        $this->collection = $collection;
        $this->rules = $rules;
    }


    public function save()
    {
        $this->validate([
            'media.*' => $this->rules,
        ]);

        foreach ($this->media as $media) {
            $this->model->addMedia($media, $this->collection);
        }
    }

}
