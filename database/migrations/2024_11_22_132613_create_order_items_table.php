<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('menu_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
}