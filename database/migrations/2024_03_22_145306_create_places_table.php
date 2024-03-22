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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')
            ->constrained('regions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('place_name');
            $table->text('place_info');
            $table->text('place_link');
            $table->string('place_image');
            $table->integer('place_point')->unsigned();
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
