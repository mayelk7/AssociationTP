<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id('id_asso');
            $table->string('nom_asso', 255);
            $table->string('email_asso', 255)->nullable();
            $table->string('ville_asso', 255)->nullable();
            $table->text('description_asso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
