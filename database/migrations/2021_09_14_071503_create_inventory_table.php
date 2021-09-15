<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('InvoiceNo');
            $table->string('StockCode')->nullable();
            $table->string('Description')->nullable();
            $table->integer('Quantity')->nullable();
            $table->string('InvoiceDate')->nullable();
            $table->float('UnitPrice')->nullable();
            $table->string('CustomerID')->nullable();
            $table->string('Country')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
