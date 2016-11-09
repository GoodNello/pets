<?php namespace GoodNello\Pets\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePetsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('goodnello_pets_pets')) {
            Schema::create('goodnello_pets_pets', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('owner_id')->unsigned()->index();
                $table->text('name')->nullable();
                $table->char('breed')->nullable();
                $table->string('species', 10)->nullable();
                $table->date('birth')->nullable();
                $table->text('description')->nullable();
                $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('goodnello_pets_pets');
    }
}
