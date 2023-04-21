<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 50);
            $table->date('invoice_Date')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('user_id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('status',45);
            // $table->unsignedBigInteger('section_id');
            // $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('gross_price');
            $table->decimal('discount', 8, 2);
            $table->decimal('TVA', 8, 2);
            $table->string('TVA_rate', 999);
            $table->decimal('total', 8, 2);
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
