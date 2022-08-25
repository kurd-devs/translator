<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('pirate_translations', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->index();
            $table->string('column_name');
            $table->string('phrase_key');
            $table->string('locale')->index();
            $table->string('value');
            $table->timestamps();

            $table->unique(['table_name', 'column_name', 'phrase_key', 'locale'], 'unique_translation_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pirate_translations');
    }
};
