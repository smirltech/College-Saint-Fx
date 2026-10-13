<?php

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('Matricule de l\'élève + classe + nombre d\'inscription');
            $table->foreignIdFor(Eleve::class)->constrained();
            $table->foreignIdFor(Classe::class)->constrained();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->string('categorie')->nullable()->default(InscriptionCategorie::normal->value);
            $table->integer('montant')->nullable();
            $table->string('status')->default(InscriptionStatus::approved->value);
            $table->unique(['eleve_id', 'annee_id'], 'eleve_annee');
            $table->timestamps();

        });
    }
};
