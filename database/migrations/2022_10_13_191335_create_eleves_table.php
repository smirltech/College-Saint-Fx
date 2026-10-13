<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('Matricule de l\'élève attribue par l\'école');
            $table->string('matricule')->nullable();
            $table->string('nom');
            $table->string('sexe')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();
            $table->json('pere')->nullable();
            $table->json('mere')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->foreignIdFor(User::class, 'user_id')->nullable()->constrained('users', 'id')->restrictOnDelete();
            $table->string('telephone')->nullable();
            $table->string('numero_permanent')->nullable()->unique()->comment('Numéro permanent de l\'élève attribue par le ministère de l\'education');
            $table->timestamps();
        });
    }
};
