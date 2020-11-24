<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewersVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewer_videos', function (Blueprint $table) {
            $table->integer('id_viewer')->references('id')->on('viewers');
            $table->integer('id_video')->references('id_video')->on('videos');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        DB::table('viewer_videos')->insert(
            [array(
                'id_viewer' => 3,
                'id_video' => 1,
                'start_date' => '2020-01-01',
                'end_date' => '2020-02-01',
            ),
            array(
                'id_viewer' => 3,
                'id_video' => 4,
                'start_date' => '2020-03-01',
                'end_date' => '2021-02-01',
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
        Schema::dropIfExists('viewer_videos');
    }
}
