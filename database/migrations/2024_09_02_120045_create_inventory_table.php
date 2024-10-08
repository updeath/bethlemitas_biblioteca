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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('ISBN');
            $table->unsignedBigInteger('id_clasifPGC');
            $table->foreign('id_clasifPGC')->references('id')->on('classifications');
            $table->string('title')->unique();
            $table->unsignedBigInteger('id_author');
            $table->foreign('id_author')->references('id')->on('authors');
            $table->tinyInteger('amount');
            $table->unsignedBigInteger('id_editorial');
            $table->foreign('id_editorial')->references('id')->on('editorials');
            $table->integer('publication_date')->nullable();
            $table->unsignedBigInteger('id_status');
            $table->foreign('id_status')->references('id')->on('book_status');
            $table->unsignedBigInteger('id_discard_reason')->nullable();
            $table->foreign('id_discard_reason')->references('id')->on('book_status');
            $table->unsignedBigInteger('id_location');
            $table->foreign('id_location')->references('id')->on('book_locations');
            $table->unsignedBigInteger('id_activity');
            $table->foreign('id_activity')->references('id')->on('activities');
            $table->tinyInteger('amount_donated')->nullable();
            $table->tinyInteger('amount_descarted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
