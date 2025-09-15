<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('product_lists', function ($table) {
            $table->increments('id')->unsigned()->index();
            $table->string('name')->index();
            $table->string('slug');
            $table->text('description', 160);
            $table->integer('featured')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->timestamps();     

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('product_lists');
    } 
}
