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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 3, 1)->default(0);
            $table->string('Reimbursables');
            $table->integer('status')->default(0);
            $table->integer('currancy')->default(0);
            $table->decimal('dollerRate', 6, 3)->default(1.0);
            $table->string('invoiceNumber');
            $table->integer('nom')->nullable();
            $table->decimal('pom', 10, 2)->nullable();
            $table->string('remark')->nullable();
            $table->date('sdate')->nullable();
            $table->integer('mark_status')->default(0);
            $table->integer('convertToD')->default(0);
            $table->integer('isReceipt')->default(0);
            $table->string('secAddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
