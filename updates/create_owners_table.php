<?php namespace GoodNello\Owners\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('goodnello_pets_owners', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('pet_id')->unsigned();
            $table->primary(['user_id', 'pet_id']);
        });

        Schema::table('goodnello_pets_pets', function($table)
        {
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('goodnello_pets_owners');
    }
}
