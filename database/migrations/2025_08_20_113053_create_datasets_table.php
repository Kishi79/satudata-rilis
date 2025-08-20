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
        Schema::create('datasets', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('external_id')->unique(); // id dari API/JSON
            $t->string('judul');
            $t->string('slug')->unique();
            $t->foreignId('opd_id')->constrained('opds')->cascadeOnDelete();
            $t->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $t->string('priode_waktu')->nullable(); // sesuai field JSON
            $t->timestamps();
            $t->index(['opd_id', 'group_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
