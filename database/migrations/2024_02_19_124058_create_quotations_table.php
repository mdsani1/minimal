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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Financial Proposal For');
            $table->string('ref')->nullable();
            $table->string('name')->nullable();
            $table->string('area')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('purpose')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('active_bank')->default(0);
            $table->string('first_person')->nullable();
            $table->string('first_person_signature')->nullable();
            $table->string('second_person')->nullable();
            $table->string('second_person_signature')->nullable();
            $table->string('third_person')->nullable();
            $table->string('third_person_signature')->nullable();
            $table->string('fourth_person')->nullable();
            $table->string('fourth_person_signature')->nullable();
            $table->string('fifth_person')->nullable();
            $table->string('fifth_person_signature')->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
