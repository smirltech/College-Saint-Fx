<?php

use App\Models\MaterielCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('materiel_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaterielCategory::class)->nullable()->constrained()->restrictOnDelete();
            $table->string('nom')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
};
