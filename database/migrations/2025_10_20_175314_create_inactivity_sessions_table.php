<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_inactivity_sessions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inactivity_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('session_start');
            $table->timestamp('last_activity');
            $table->integer('idle_timeout')->default(300);
            $table->integer('warning_count')->default(0);
            $table->enum('status', ['active', 'idle', 'timed_out', 'logged_out'])->default('active');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('last_activity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inactivity_sessions');
    }
};