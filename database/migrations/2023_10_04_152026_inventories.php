<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Item;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->deleteOnCascade();
            $table->foreignIdFor(Item::class)->constrained()->deleteOnCascade();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('inventories');
    }
};
