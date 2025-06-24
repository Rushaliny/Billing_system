<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('paybills', function (Blueprint $table) {
        $table->id();
        // $table->string('customer_name');
        // $table->string('customer_address')->nullable();
        // $table->string('nic');
        $table->string('payee_account_number');
        $table->string('mobile');
        $table->string('service_type');
        $table->string('account_number');
        // $table->string('district');
        $table->string('bill_month'); // Instead of $table->date('bill_month');
        $table->decimal('base_amount', 10, 2);
        $table->decimal('additional_charges', 10, 2);
        $table->decimal('total_amount', 10, 2);
        $table->string('payment_status');
        $table->string('payment_method');
        $table->text('cancel_reason')->nullable();
        $table->string('receipt_path')->nullable();

        $table->timestamps();
    });
}   


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paybills');
    }
};
