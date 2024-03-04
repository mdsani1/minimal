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
        Schema::create('interiors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('item');
            $table->longText('specification1')->nullable();
            $table->longText('specification2')->nullable();
            $table->longText('specification3')->nullable();
            $table->float('qty')->nullable();
            $table->string('unit')->nullable();
            $table->float('rate')->nullable();
            $table->float('amount')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('feet')->nullable();
            $table->string('inche')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interiors');
    }
};
