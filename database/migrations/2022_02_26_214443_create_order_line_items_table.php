<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_line_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->smallInteger('quantity');
            $table->bigInteger('vendor_id');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE order_line_items AUTO_INCREMENT = 45678;"); // Since the test starts from 45678

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_line_items');
    }
};
