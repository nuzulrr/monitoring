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
        Schema::create('site', function (Blueprint $table) {
          $table->id('id_site');

        // relasi ke projek
        $table->foreignId('id_projek')
              ->constrained('projek', 'id_projek')
              ->onDelete('cascade');

        $table->string('alamat');
        $table->string('projek');


        // koordinat map
        $table->decimal('latitude', 10, 6);
        $table->decimal('longitude', 10, 6);
        $table->string('ip_address')->unique();
        $table->text('note')->nullable();
        $table->date('tgl_instalasi');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site');
    }
};
