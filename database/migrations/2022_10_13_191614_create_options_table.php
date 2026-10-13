<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections');

            $table->timestamps();
        });
    }
};
