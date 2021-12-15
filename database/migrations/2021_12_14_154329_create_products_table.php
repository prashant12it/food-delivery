<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name',255);
            $table->string('slug',191)->unique('pr_slg');
            $table->integer('category_id');
            $table->integer('brand_id')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->double('price',8,2)->default(0);
            $table->integer('quantity')->default(0);
            $table->tinyInteger('is_featured')->default(0)->comment('0: No, 1: Yes');
            $table->double('discount',8,2)->default(0);
            $table->string('upsell_products')->nullable();
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
        Schema::dropIfExists('products');
    }
}
