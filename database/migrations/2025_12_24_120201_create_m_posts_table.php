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
        Schema::create('t_posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul_posts');
            $table->unsignedBigInteger('id_modul')->nullable();
            $table->unsignedBigInteger('parent_post_id')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_location')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('id_modul')->references('id')->on('m_modul')->onDelete('set null');
            $table->foreign('parent_post_id')->references('id')->on('t_posts')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_posts');
    }
};