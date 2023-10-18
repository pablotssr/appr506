<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pet;
use App\Models\Action;
use App\Models\Event;
use App\Models\User;
use App\Models\Diary;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('moves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Action::class,'action1')->nullable()->constrained('actions')->deleteOnCascade();
            $table->foreignIdFor(Action::class,'action2')->nullable()->constrained('actions')->deleteOnCascade();
            $table->foreignIdFor(User::class)->constrained()->deleteOnCascade();
            $table->foreignIdFor(Pet::class)->constrained()->deleteOnCascade();
            $table->integer('score')->nullable();
            $table->foreignIdFor(Event::class)->nullable()->deleteOnCascade();
            $table->foreignIdFor(Diary::class)->nullable()->constrained()->deleteOnCascade();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('moves');
    }
};
