<?php

use App\Models\Annee;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consommables', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->integer('stock_minimum')->nullable();
            $table->foreignIdFor(Unit::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
