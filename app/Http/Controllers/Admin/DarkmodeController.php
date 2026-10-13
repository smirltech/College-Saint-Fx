<?php

namespace App\Http\Controllers\Admin;

class DarkmodeController extends \JeroenNoten\LaravelAdminLte\Http\Controllers\DarkModeController
{

    public function toggle()
    {
        parent::toggle();

        return redirect()->back();
    }
}
