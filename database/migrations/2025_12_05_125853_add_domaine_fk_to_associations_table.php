<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->unsignedBigInteger('domaine_id')->after('description_asso');

            $table->foreign('domaine_id')
                ->references('id_domaine')
                ->on('domaine')
                ->onDelete('cascade');
        });
    }

    public function down()
    {

        Schema::table('associations', function (Blueprint $table) {
            $table->dropColumn('domaine_id');
            $table->dropForeign(['domaine_id']);
        });
    }

};
