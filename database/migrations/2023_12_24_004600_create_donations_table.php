<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('clasifpgc');
            $table->string('title');
            $table->integer('amount');
            $table->enum('category', ['libro','tornos', 'cartilla', 'afiche', 'folleto', 'texto']);
            $table->string('author');
            $table->string('editorial');
            $table->enum('status', ['well','regular','bad']);
            $table->enum('activite', ['reference_material','investigation', 'teaching', 'consultation', 'languagues', 'reading']);
            $table->string('area');
            $table->string('image')->nullable();
            $table->year('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
