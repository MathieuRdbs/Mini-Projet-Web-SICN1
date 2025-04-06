<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToTPriceInCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('t_price', 8, 2)->default(0)->change(); // Définit la valeur par défaut à 0
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('t_price', 8, 2)->default(null)->change(); // Annule la valeur par défaut si nécessaire
        });
    }
}
