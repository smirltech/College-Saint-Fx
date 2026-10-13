<?php

namespace App\Http\Livewire\Profile;

use App\Enums\MediaType;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class EditAvatarModal extends Component
{
    use WithFileUploads, HasLivewireAlert;

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
        return view('livewire.profile.edit-avatar-modal');
    }

    //submit
    #[NoReturn] public function submit(): void
    {

        if ($this->avatar) {
            // delete old avatar
            $old_avatars = $this->model->media()->where('collection_name', MediaType::avatar->folder())->get();
            foreach ($old_avatars as $old_avatar) {
                $old_avatar->delete();
            }
        }
        if (is_array($this->avatar)) {
            $this->avatar = $this->avatar[0];
        }
        $this->model->addMedia($this->avatar, MediaType::avatar->folder());

        $this->success("La photo de profil a été modifiée avec succès");
        $this->emit('hideModal');
        $this->emit('refresh');
    }
}
