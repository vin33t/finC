<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryPairVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_pair_visas', function (Blueprint $table) {
            $table->id();
            $table->integer('visaCountryPairId');
            $table->integer('visaCategoryId');

            $table->longText('visaDetails');

            $table->integer('singleEntry')->default(0);
            $table->integer('singleEntryProcessing')->default(0);
            $table->integer('singleEntryValidity')->default(0);
            $table->float('singleEntryEmbassyFee')->default(0);
            $table->float('singleEntryServiceFee')->default(0);
            $table->float('singleEntryVat')->default(0);

            $table->integer('multipleEntry')->default(0);
            $table->integer('multipleEntryProcessing')->default(0);
            $table->integer('multipleEntryValidity')->default(0);
            $table->float('multipleEntryEmbassyFee')->default(0);
            $table->float('multipleEntryServiceFee')->default(0);
            $table->float('multipleEntryVat')->default(0);

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
        Schema::dropIfExists('country_pair_visas');
    }
}
