<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoSvodPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_svod_packages', function (Blueprint $table) {
            $table->integer('id_video');
            $table->integer('id_package');
            $table->timestamps();
        });

        DB::table('videos_svod_packages')->insert(
            [array(
                'id_video' => 8,
                'id_package' => 4
            ),
            array(
                'id_video' => 7,
                'id_package' => 3
            ),
            array(
                'id_video' => 6,
                'id_package' => 2
            ),
            array(
                'id_video' => 5,
                'id_package' => 2
            ),
            array(
                'id_video' => 4,
                'id_package' => 4
            ),
            array(
                'id_video' => 3,
                'id_package' => 3
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
        Schema::dropIfExists('videos_svod_packages');
    }
}
