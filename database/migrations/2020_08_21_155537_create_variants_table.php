<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('color_family')->nullable();
            $table->text('photos')->nullable();
            $table->string('SKU')->nullable();
            $table->unsignedInteger('quantity');
            $table->boolean('is_available');
            $table->double('sale_price');
            $table->double('special_price')->default(0);
            $table->double('shipping_fee_multiplier')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
