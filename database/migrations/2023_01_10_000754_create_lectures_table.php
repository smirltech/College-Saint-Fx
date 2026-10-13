<?php

use App\Models\Ouvrage;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ouvrage::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
