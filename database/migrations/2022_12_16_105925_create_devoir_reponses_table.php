<?php

use App\Enums\DevoirReponseStatus;
use App\Models\Devoir;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('devoir_reponses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Devoir::class)->constrained();
            $table->foreignIdFor(Eleve::class)->constrained();
            $table->longText('contenu')->nullable();
            $table->string('status')->default(DevoirReponseStatus::pending->value);
            $table->timestamps();
        });
    }
};
