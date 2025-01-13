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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('operation_type'); // Тип: депозит, списание, перевод
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('related_user_id')->nullable();
            $table->decimal('exchange_rate', 10, 4)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            // На данный момент пользователей нет, на бою должно быть так
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('related_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
