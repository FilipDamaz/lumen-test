<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvodPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svod_packages', function (Blueprint $table) {
            $table->increments('id_package');
            $table->string('name');
            $table->string('description');
            $table->boolean('is_active')->default(false);
            $table->integer('duration')->comment('number of days');
            $table->integer('parent_id')->nullable();
            $table->decimal('price',6,2);
            $table->string('currency');
            $table->timestamps();
        });

        DB::table('svod_packages')->insert(
            [[
                'id_package' => 1,
                'name' => 'SVOD1',
                'description' => 'SVOD1 description',
                'is_active' => true,
                'duration' => 30,
                'parent_id' => NULL,
                'price' => 40.00,
                'currency' => 'EUR'
            ],
            [
                'id_package' => 2,
                'name' => 'SVOD2',
                'description' => 'SVOD2 description',
                'is_active' => true,
                'duration' => 30,
                'parent_id' => 1,
                'price' => 30.00,
                'currency' => 'EUR'
            ],
            [
                'id_package' => 3,
                'name' => 'SVOD3',
                'description' => 'SVOD3 description',
                'is_active' => true,
                'duration' => 10,
                'parent_id' => 2,
                'price' => 20.00,
                'currency' => 'EUR'
            ],
            [
                'id_package' => 4,
                'name' => 'SVOD4',
                'description' => 'SVOD4 description',
                'is_active' => true,
                'duration' => 20,
                'parent_id' => 2,
                'price' => 20.00,
                'currency' => 'EUR'
            ],
            [
                'id_package' => 5,
                'name' => 'SVOD5',
                'description' => 'SVOD5 description',
                'is_active' => false,
                'duration' => 20,
                'parent_id' => 1,
                'price' => 50.00,
                'currency' => 'EUR'
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
        Schema::dropIfExists('svod_packages');
    }
}
