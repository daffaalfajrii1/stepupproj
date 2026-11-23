<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('team')->nullable();
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('tone')->default(1);
            $table->string('link_one_label')->nullable();
            $table->string('link_one_url')->nullable();
            $table->string('link_two_label')->nullable();
            $table->string('link_two_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
