<?php

use App\Enums\DevoirStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Cours;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('devoirs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Classe::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Cours::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->string('titre');
            $table->mediumText('contenu')->nullable();
            $table->dateTime('echeance');
            $table->string('status')->default(DevoirStatus::draft->name);
            $table->timestamps();
        });
    }
};
