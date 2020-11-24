<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewersSvodPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewers_svod_package', function (Blueprint $table) {
            $table->integer('id_viewer')->references('id')->on('viewers');
            $table->integer('id_package')->references('id_package')->on('svod_package');;
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        DB::table('viewers_svod_package')->insert(
           [ array(
                'id_viewer' => 1,
                'id_package' => 1,
                'start_date' => '2020-01-01',
                'end_date' => '2020-02-01',
            ),
            array(
                'id_viewer' => 1,
                'id_package' => 3,
                'start_date' => '2020-03-01',
                'end_date' => '2021-02-01',
            ),
            array(
                'id_viewer' => 2,
                'id_package' => 1,
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
        Schema::dropIfExists('viewers_svod_package');
    }
}
