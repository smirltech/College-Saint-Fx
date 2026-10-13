<?php

use App\Enums\MaterialStatus;
use App\Models\MaterielCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignIdFor(MaterielCategory::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'edited_by')->constrained('users', 'id')->restrictOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('montant')->nullable();
            $table->date('date')->nullable();
            $table->integer('vie')->nullable();
            $table->string('status')->default(MaterialStatus::ok->name);
            $table->timestamps();
        });
    }
};
