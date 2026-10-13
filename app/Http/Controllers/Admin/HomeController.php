<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }


    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }

        $boxes = [
            [
                'title' => 23,
                'text' => 'Inscrits',
                'icon' => 'fas fa-bicycle',
                'url' => "#",
                'theme' => 'danger',
            ],
            [
                'title' => 23,
                'text' => 'Validés',
                'icon' => 'fas fa-bed',
                'url' => "#",
                'theme' => 'primary',
            ],
            [
                'title' => "23",
                'text' => 'Rejetés',
                'icon' => 'fas fa-hotel',
                'url' => "#",
                'theme' => 'warning',
            ],
            [
                'title' => "24",
                'text' => 'Admis',
                'icon' => 'fas fa-ticket-alt',
                'url' => "#",
                'theme' => 'success',
            ]
        ];


        return view('admin.dashboard', compact('boxes'))->with('title', ' - Dashboard');

    }
}
