<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedAndUpdatedFieldRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procurement_records', function (Blueprint $table) {
            $table->bigInteger('created_user_by_id')->nullable()->after('link_url');
            $table->bigInteger('updated_user_by_id')->nullable()->after('link_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procurement_records', function (Blueprint $table) {
            $table->dropColumn('created_user_by_id');
            $table->dropColumn('updated_user_by_id');
        });
    }
}
