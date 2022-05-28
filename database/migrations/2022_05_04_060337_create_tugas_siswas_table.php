<?php

use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tugas::class);
            $table->foreignIdFor(User::class);
            $table->string('tgl_kumpul');
            $table->string('file_tugas_siswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_siswas');
    }
};
