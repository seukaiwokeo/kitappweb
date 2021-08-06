<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Roles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('hierarchical_order');
            $table->string('title')->unique();
            $table->boolean('can_manage_books')->default(false);
            $table->boolean('can_manage_users')->default(false);
            $table->boolean('can_manage_posts')->default(false);
            $table->boolean('can_manage_comments')->default(false);
            $table->boolean('can_manage_authors')->default(false);
            $table->boolean('can_manage_reviews')->default(false);
            $table->boolean('can_manage_categories')->default(false);
            $table->boolean('can_manage_dictionary')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
