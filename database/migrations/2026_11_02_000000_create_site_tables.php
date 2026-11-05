<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Edited copy for one language of one group (home, about, services, contact, global).
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5);
            $table->string('group', 40);
            $table->json('data');
            $table->timestamps();

            $table->unique(['locale', 'group']);
        });

        // Replacement images. A row exists only when the default image has been replaced.
        Schema::create('site_images', function (Blueprint $table) {
            $table->id();
            $table->string('key', 80)->unique();
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_images');
        Schema::dropIfExists('site_contents');
    }
};
