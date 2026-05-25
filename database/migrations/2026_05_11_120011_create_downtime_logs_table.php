<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// database/migrations/xxxx_create_downtime_logs_table.php
public function up(): void
{
    Schema::create('downtime_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_site');
        $table->string('ip_address');
        $table->string('projek');
        $table->string('status');                    // offline | unreachable
        $table->timestamp('down_at');                // kapan mulai down
        $table->timestamp('recovered_at')->nullable(); // kapan recover
        $table->integer('durasi_menit')->nullable();  // durasi dalam menit
        $table->boolean('alert_sent')->default(false); // email sudah dikirim?
        $table->timestamps();

        $table->foreign('id_site')
              ->references('id_site')
              ->on('site')
              ->onDelete('cascade');

        $table->index(['id_site', 'down_at']);
        $table->index('recovered_at');
    });
}

public function down(): void
{
    Schema::dropIfExists('downtime_logs');
}};
