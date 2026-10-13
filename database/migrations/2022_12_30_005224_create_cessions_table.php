<?php

use App\Models\Materiel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Materiel::class)->constrained()->restrictOnDelete();
            $table->integer('montant')->nullable();
            $table->date('date');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
