<?php

use App\Models\Annee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('paiments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->morphs('paimentable');
            $table->float('montant');
            $table->string('mois'); //App\Enum\Mois
            $table->string('motif')->nullable(); //App\Enum\PaiementMotif
            $table->foreignIdFor(Annee::class)->constrained();
            $table->timestamps();
        });
    }
};
