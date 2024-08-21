<?php

use App\Models\User;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreignIdFor(User::class); Other way
            $table->string('sku', 45)->unique();
            $table->integer('stock')->default(0);
            $table->integer('reorder_level');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
