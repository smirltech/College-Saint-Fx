<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perceptions', function (Blueprint $table) {
            $table->integer('taux', )->nullable()->after('montant');
        });
    }
};
