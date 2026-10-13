<?php

use App\Enums\MaterialStatus;
use App\Enums\MouvementStatus;
use App\Models\Materiel;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Materiel::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users', 'id')->restrictOnDelete();
            $table->foreignIdFor(User::class, 'facilitateur_id')->constrained('users', 'id')->restrictOnDelete();
            $table->string('beneficiaire');
            $table->date('date');
            $table->string('direction')->default(MouvementStatus::in->name);
            $table->string('materiel_status')->default(MaterialStatus::ok->name);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
