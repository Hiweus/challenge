<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('agency');
            $table->string('number', 20);
            $table->integer('digit');
            $table->enum('type', ['Company', 'Person']);

            $table->string('name');
            $table->string('document')->unique();
            $table->string('social_reason')->nullable();


            $table->integer('fk_user')->referencies('id')->on('users');
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
        Schema::dropIfExists('accounts');
    }
}
