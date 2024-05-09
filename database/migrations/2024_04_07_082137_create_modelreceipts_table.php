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
        Schema::create('modelreceipts', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceNumber')->nullable();
            $table->string('receiptNumber');
            $table->string('additional')->default(0);
            $table->date('payedDate');
            $table->integer('offline')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelreceipts');
    }
};
