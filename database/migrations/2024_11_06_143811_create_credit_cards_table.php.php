<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->string('expiration_month', 2);
            $table->string('expiration_year', 2);
            $table->decimal('credit_limit', 10, 2);
            $table->decimal('available_balance', 10, 2);
            $table->string('cred_id')->unique();
            $table->string('card_type')->default('visa');
            $table->string('card_color')->default('blue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_cards');
    }
};