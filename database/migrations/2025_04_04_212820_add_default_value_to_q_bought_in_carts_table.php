<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToQBoughtInCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('q_bought')->default(1)->change(); // Définir la valeur par défaut à 1
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('q_bought')->default(null)->change(); // Annuler la valeur par défaut si nécessaire
        });
    }
}

