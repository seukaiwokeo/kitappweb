<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('summary')->nullable();
            $table->unsignedInteger('page_count')->default(0);
            $table->unsignedBigInteger('author')->default(0);
            $table->string('cover')->default('default');
            $table->json('categories')->default('{}');
            $table->json('keywords')->default('{}');
            $table->unsignedBigInteger('product')->default(0);
            $table->unsignedBigInteger('read_count')->default(0);
            $table->unsignedBigInteger('to_read_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->unsignedBigInteger('unlike_count')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('market_link')->nullable();
            $table->double('market_price')->default(0)->nullable();
            $table->date('publishing_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
