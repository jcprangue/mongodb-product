<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_records', function (Blueprint $table) {
            $table->id();
            $table->date('bid_opening_date')->nullable();
            $table->string('ib_number')->nullable();
            $table->text('project_name')->nullable();
            $table->string('contractor')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('lgu_id')->nullable();
            $table->integer('barangay_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('status')->nullable();
            $table->text('remarks')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('procurement_records');
    }
}
