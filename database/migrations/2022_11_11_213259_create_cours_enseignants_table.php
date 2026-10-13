<?php

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Enseignant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cours_enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cours::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Classe::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Enseignant::class)->nullable()->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
