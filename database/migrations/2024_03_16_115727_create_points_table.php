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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('region_id')
            ->constrained('regions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('point')->unsigned();
            $table->string('title');
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
