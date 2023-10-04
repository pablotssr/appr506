<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Item;
use App\Models\Diary;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class,'item1')->constrained()->deleteOnCascade();
            $table->foreignIdFor(Item::class,'item2')->constrained()->deleteOnCascade();
            $table->foreignIdFor(Item::class,'item3')->constrained()->deleteOnCascade();
            $table->foreignIdFor(Diary::class)->constrained()->deleteOnCascade();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('shops');
    }
};
