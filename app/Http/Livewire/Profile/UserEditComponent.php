<?php

namespace App\Http\Livewire\Profile;

use App\Enums\MediaType;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class UserEditComponent extends Component
{
    use WithFileUploads, HasLivewireAlert;

    public mixed $avatar = null;

    // mount
    public User $user;
    public Collection $permissions;

    public Collection $roles;
    protected $listeners = ['refresh' => '$refresh'];

    /**
     * @throws Exception
     */
    public function mount(User $user): void
    {
        $this->user = $user;
        $this->permissions = Permission::all();
        $this->roles = Role::all();
    }

    public function render(): Factory|View|Application
    {
        $this->title = "{$this->user->name}";
        return view('livewire.profile.edit')->layoutData(['title' => $this->title, "contentHeaderIcon" => "fas fa-fw fa-user"]);
    }

    //submit
    #[NoReturn] public function submit(): void
    {

        if ($this->avatar) {
            // delete old avatar
            $old_avatars = $this->user->media()->where('collection_name', MediaType::avatar->folder())->get();
            foreach ($old_avatars as $old_avatar) {
                $old_avatar->delete();
            }
            if (is_array($this->avatar)) {
                $this->avatar = $this->avatar[0];
            }
            $this->user->addMedia($this->avatar, MediaType::avatar->folder());
        }

        $this->success("La photo de profil a été modifiée avec succès");
        $this->emit('hideModal');
        $this->emit('refresh');
    }
}
