<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_modul', function (Blueprint $table) {
            $table->id();
            $table->string('nama_modul');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('nama_kategori')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('id_kategori')->references('id')->on('m_kategori')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_modul');
    }
};