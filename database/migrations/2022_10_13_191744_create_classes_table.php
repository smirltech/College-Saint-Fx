<?php

use App\Models\Enseignant;
use App\Models\Option;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('niveau');
            $table->foreignIdFor(Section::class);
            $table->foreignIdFor(Option::class)->nullable();
            $table->foreignIdFor(Enseignant::class)->nullable()->comment('Titulaire');
            $table->timestamps();
        });
    }
};
