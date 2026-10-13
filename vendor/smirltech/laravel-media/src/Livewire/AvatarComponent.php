<?php

namespace SmirlTech\LaravelMedia\Livewire;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithFileUploads;

class AvatarComponent extends Component
{
    use WithFileUploads;

    const avatar_folder = 'avatars';
    public mixed $avatar = null;

    // mount
    public mixed $model;

    /**
     * @throws Exception
     */
    #[NoReturn] public function mount(string $model_type, string $model_id): void
    {

        $model_type = 'App\\Models\\' . $model_type;

        if ($model_id && class_exists($model_type)) {
            $this->model = $model_type::find($model_id);
            if (!$this->model->exists) {
                throw new Exception("No model found with id '{$model_id}'");
            }
        } else {
            throw new Exception("The model '{$model_type}' does not exist");
        }
    }

    public function render(): Factory|View|Application
    {
        return view('media::livewire.avatar-component');
    }

    //submit
    #[NoReturn] public function submit(): void
    {

        if ($this->avatar) {
            // delete old avatar
            $old_avatars = $this->model->media()->where('collection_name', self::avatar_folder)->get();
            foreach ($old_avatars as $old_avatar) {
                $old_avatar->delete();
            }
        }
        if (is_array($this->avatar)) {
            $this->avatar = $this->avatar[0];
        }
        $this->model->addMedia($this->avatar, self::avatar_folder);

        $this->emit('avatarUpdated');
        $this->emit('hideModal');
        $this->emit('refresh');
    }
}
