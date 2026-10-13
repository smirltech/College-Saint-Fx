<?php

use App\Models\Rayon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rayons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rayon::class)->nullable()->constrained()->restrictOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
};
