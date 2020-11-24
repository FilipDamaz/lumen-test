<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id_video');
            $table->string('name');
            $table->decimal('price',6,2);
            $table->string('currency');
            $table->timestamps();
        });

        DB::table('videos')->insert(
            [array(
                'id_video' => 1,
                'name' => 'Video1',
                'price' => '39.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 2,
                'name' => 'Video2',
                'price' => '29.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 3,
                'name' => 'Video3',
                'price' => '49.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 4,
                'name' => 'Video4',
                'price' => '19.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 5,
                'name' => 'Video5',
                'price' => '39.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 6,
                'name' => 'Video6',
                'price' => '69.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 7,
                'name' => 'Video7',
                'price' => '69.00',
                'currency' => 'EUR'
            ),
            array(
                'id_video' => 8,
                'name' => 'Video8',
                'price' => '79.00',
                'currency' => 'EUR'
            )]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
