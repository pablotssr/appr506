<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->deleteOnCascade();
            $table->string('name',20);
            $table->integer('color');
            $table->integer('age')->default(1);
            $table->date('birth');
            $table->integer('health');
            $table->integer('mental');
            $table->integer('iq');
            $table->integer('clean');
            $table->boolean('alive')->default(true);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('pets');
    }
};
