<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->increments('id');
            $table->string('flag');  //0 是本校现场赛　1 是外校现场赛　2 是网络赛
            $table->string('school')->default('东秦');
            $table->string('team_name');

            $table->string('leader');
            $table->string('qq0');
            $table->string('sex0')->nullable();
            $table->string('mobile0');
            $table->string('college0')->nullable();
            $table->string('std_num0')->nullable();

            $table->string('member1')->nullable();
            $table->string('qq1')->nullable();
            $table->string('sex1')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('college1')->nullable();
            $table->string('std_num1')->nullable();

            $table->string('member2')->nullable();
            $table->string('qq2')->nullable();
            $table->string('sex2')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('college2')->nullable();
            $table->string('std_num2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
}
