<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inactivity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('idle_duration'); // in seconds
            $table->enum('type', ['alert', 'warning', 'logout']);
            $table->text('reason')->nullable();
            $table->timestamp('triggered_at');
            $table->timestamps();

            $table->index(['user_id', 'triggered_at']);
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inactivity_logs');
    }
};