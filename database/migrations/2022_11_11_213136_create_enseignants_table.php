<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nom');
            $table->string('email')->unique()->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('matricule')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->string('sexe')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->default('Congolaise');
            $table->foreignIdFor(Section::class)->nullable();

            $table->string('niveau')->nullable();
            $table->string('specialite')->nullable();
            $table->string('diplome')->nullable();
            $table->date('date_embauche')->nullable();
            $table->date('date_depart')->nullable();
            $table->text('motif_depart')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
};
