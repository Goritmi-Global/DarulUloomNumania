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
        Schema::create('salaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_id');
            $table->uuid('advance_type_id')->nullable();
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
