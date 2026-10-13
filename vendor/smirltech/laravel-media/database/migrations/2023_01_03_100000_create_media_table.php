<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulidMorphs('model');
            $table->string('mime_type');

            $table->string('filename');
            $table->string('location');
            $table->json('custom_properties')->nullable();
            $table->string('collection_name')->default('default');
            $table->string('size')->nullable();

            $table->timestamps();
        });
    }
};
