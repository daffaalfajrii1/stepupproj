<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visited_on')->unique();
            $table->unsignedInteger('total')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_visits');
    }
};
