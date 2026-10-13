<?php

use Illuminate\Support\Facades\Route;
use SmirlTech\LaravelMedia\Controllers\MediaController;

Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
