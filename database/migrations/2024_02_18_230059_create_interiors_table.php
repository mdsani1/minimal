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
            $table->float('qty',8, 2)->nullable();
            $table->string('unit')->nullable();
            $table->float('rate',8, 2)->nullable();
            $table->float('amount',8, 2)->nullable();
            $table->string('length_feet')->nullable();
            $table->string('length_inche')->nullable();
            $table->string('width_feet')->nullable();
            $table->string('width_inche')->nullable();
            $table->string('height_feet')->nullable();
            $table->string('height_inche')->nullable();
            $table->tinyInteger('active')->default(1);
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
