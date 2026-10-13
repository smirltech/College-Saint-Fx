<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->text('reason')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->ulidMorphs('model');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
}
