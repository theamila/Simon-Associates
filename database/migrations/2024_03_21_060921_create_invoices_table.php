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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('1');
            $table->string('to');
            $table->string('email');
            $table->string('companyName');
            $table->text('address');
            $table->string('invoiceNumber');
            $table->string('currency')->default('LKR');
            $table->decimal('dollerRate', 10, 2)->default(1.0);
            $table->date('date')->default(date('Y-m-d'));
            $table->date('sendDate')->default(date('Y-m-d'));
            $table->string('handleBy');
            $table->integer('resend')->default(0);
            $table->integer('refID');
            $table->integer('customerRefId');
            $table->integer('bankId')->nullable();
            $table->string('debtor')->nullable();
            $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
