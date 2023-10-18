<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pet;
use App\Models\User;
use App\Models\Action;
use App\Models\Event;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('diaries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->deleteOnCascade();
            $table->foreignIdFor(Pet::class)->constrained()->deleteOnCascade();
            $table->integer('pet_age')->nullable();
            $table->foreignIdFor(Action::class)->deleteOnCascade();
            $table->foreignIdFor(Event::class)->nullable()->deleteOnCascade();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('diaries');
    }
};
