<?php

use App\Enums\Conduite;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Inscription::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Classe::class)->constrained()->restrictOnDelete();
            $table->integer('custom_property')->nullable()->comment("periodes, examens et autres totaux sont attribués un numéro pour pouvoir les trier en ordre");
            $table->string('pourcentage')->nullable();
            $table->integer('place')->nullable();
            $table->string('conduite')->nullable()->default(Conduite::b->name);
            $table->timestamps();
        });
    }
};
