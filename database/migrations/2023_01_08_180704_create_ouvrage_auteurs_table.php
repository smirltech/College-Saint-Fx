<?php

use App\Models\Auteur;
use App\Models\Ouvrage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ouvrage_auteurs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ouvrage::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Auteur::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
