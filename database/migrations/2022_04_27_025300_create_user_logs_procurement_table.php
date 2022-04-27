<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsProcurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs_procurement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurement_record_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('action')->nullable();
            $table->foreign('procurement_record_id')->references('id')->on('procurement_records');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_logs_procurement');
    }
}
