<?php

use App\Enums\Devise;
use App\Models\Annee;
use App\Models\DepenseType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(DepenseType::class)->constrained();
            $table->float('montant');
            $table->string('devise')->default(Devise::USD->value);
            $table->string('motif')->nullable();
            $table->string('beneficiaire')->nullable();
            $table->text('note')->nullable();
            $table->date('date')->nullable();
            $table->string('reference')->nullable();
            $table->json('reviewers')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
