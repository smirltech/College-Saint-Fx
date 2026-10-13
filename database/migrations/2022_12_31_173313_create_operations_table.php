<?php

use App\Enums\MouvementStatus;
use App\Models\Consommable;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Consommable::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users', 'id')->restrictOnDelete();
            $table->foreignIdFor(User::class, 'facilitateur_id')->constrained('users', 'id')->restrictOnDelete();
            $table->string('beneficiaire')->nullable();
            $table->integer('quantite');
            $table->date('date');
            $table->string('direction')->default(MouvementStatus::in->name);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
