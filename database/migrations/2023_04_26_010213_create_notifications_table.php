<?php

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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from')->unsigned()->index();
            $table->foreign('from')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('to')->unsigned()->index();
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('swapbook_id')->unsigned()->index();
            $table->foreign('swapbook_id')->references('id')->on('books')->onDelete('cascade');
            $table->bigInteger('notification_checked')->default(0)->unsigned();
           

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
