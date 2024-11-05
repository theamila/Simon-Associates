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
        Schema::table('modelreceipts', function (Blueprint $table) {
            $table->decimal('payedAmount', 10, 2)->after('payedDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modelreceipts', function (Blueprint $table) {
            $table->dropColumn('payedAmount');
        });
    }
};
