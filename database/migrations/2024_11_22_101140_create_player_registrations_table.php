<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('player_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('fide_id')->nullable();
            $table->string('aicf_id')->nullable();
            $table->string('fide_rating')->nullable();
            $table->string('state_membership_id')->nullable();
            $table->string('player_name');
            $table->text('residential_address')->nullable();
            $table->string('gender');
            $table->string('father_name')->nullable();
            $table->string('state');
            $table->date('dob');
            $table->string('district');
            $table->string('mobile_1');
            $table->string('taluk')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('email');
            $table->string('school_college_name')->nullable();
            $table->string('online_chess_id')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_registrations');
    }
};
