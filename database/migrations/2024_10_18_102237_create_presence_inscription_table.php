<?php

use App\Enums\PresenceStatus;
use App\Models\Annee;
use App\Models\Inscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presence_inscription', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Inscription::class)->constrained()->restrictOnDelete();
            $table->string('status')->default(PresenceStatus::PRESENT->value);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
