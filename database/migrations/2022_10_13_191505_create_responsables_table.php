<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nom');
            $table->string('sexe')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('profession')->nullable();
            $table->string('email')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();
        });
    }
};
