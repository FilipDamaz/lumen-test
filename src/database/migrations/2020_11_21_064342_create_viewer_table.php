<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('token');
            $table->timestamps();
        });


        DB::table('viewers')->insert(
            [[
                'id' => 1,
                'name' => 'Viewer1',
                'token' => '1111'
            ],
            [
                'id' => 2,
                'name' => 'Viewer2',
                'token' => '1122'
            ],
            [
                'id' => 3,
                'name' => 'Viewer3',
                'token' => '1133'
            ]]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viewers');
    }
}
