<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Option;
use App\Models\Role;
use App\Models\User;
use App\Notifications\PasswordResettedNotification;
use App\Notifications\UserCreatedNotification;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        // get user not super admins, use spatie permission
        $users = User::getStaff();

        return view('users.index', compact('users'))->with('title', __('Utilisateurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {

        User::create($request->validated());

        // Send an email to the user with the password, surround with try/catch to prevent errors
      /*  try {
            $user->notify(new UserCreatedNotification($password));
        } catch (Exception $e) {
            // log the error
            Log::error($e->getMessage());

            // undo the user creation
            $user->delete();

            // redirect to the user creation page with an error message
            return redirect()->route('users.create')->with('error', __('Une erreur est survenue lors de l\'envoi du mail. Veuillez réessayer.'));
        }*/


        return redirect()->route('users.index')->with('success', __(':resource created successfully!', ['resource' => __('User')]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {


        $roles = Role::where('name', '!=', 'super-admin')->where('name', '!=', UserRole::parent->value)->where('name', '!=', UserRole::eleve->value)->get();

        $options = Option::all();

        return view('users.create', compact('roles', 'options'))->with('title', __('Ajouter un utilisateur'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $facultes = Option::all();
    }

    public function resetPassword(Request $request, User $user)
    {

        $password = Str::random(8);

        $user->password = $password;


        // Send an email to the user with the password, surround with try/catch to prevent errors
        try {
            $user->notify(new PasswordResettedNotification($password));
            $user->save();
        } catch (Exception $e) {
            // log the error
            Log::error($e->getMessage());

            // redirect to the user creation page with an error message
            return redirect()->back()->with('error', __('Une erreur est survenue lors de l\'envoi du mail. Veuillez réessayer.'));
        }

        return redirect()->back()->with('success', __('Le nouveau mot de passe a été envoyé à votre addresse email :' . $user->email));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $user->update($request->validated());

        return redirect()->back()->with('success', __('Modification réussie'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'))->with('success', __('The action ran successfully!'));
    }
}
