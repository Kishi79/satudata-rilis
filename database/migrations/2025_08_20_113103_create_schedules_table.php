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
        Schema::create('schedules', function (Blueprint $t) {
            $t->id();
            $t->foreignId('dataset_id')->nullable()->constrained('datasets')->nullOnDelete();
            $t->foreignId('opd_id')->constrained('opds')->cascadeOnDelete(); // simpan juga untuk pencarian cepat
            $t->string('judul_dataset'); // denormalisasi untuk kasus dataset manual
            $t->date('release_date');
            $t->enum('status', ['akan_dirilis', 'tertunda', 'sudah_dirilis'])->default('akan_dirilis');
            $t->text('catatan')->nullable();
            $t->timestamps();
            $t->index(['release_date', 'status']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
