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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable();
            $table->string("ship_name");
            $table->string("ship_owner");
            $table->longText("address_owner");
            $table->string("ship_size");
            $table->string("captain");
            $table->string("member");
            $table->longText("ship_images");
            $table->string("permit_number");
            $table->longText("permit_document");
            $table->timestamps();
            $table->datetime("approved_at")->nullable();
            $table->integer("approved_by")->nullable();
            $table->integer("created_by");
            $table->longText("reason")->nullable();
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
        Schema::dropIfExists('ships');
    }
};
