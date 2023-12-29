<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            //no hace falta indicar la tabla en constrained, mediante las convenciones laravel ya lo relaciona
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //Aquí si hay que indicar a que tabla hace referencia, ya que no sigue las convenciones de los nombres (no podemos tener dos user_id).
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
