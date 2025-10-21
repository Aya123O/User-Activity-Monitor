<?php
// database/migrations/2025_10_21_150845_create_penalties_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table already exists before creating
        if (!Schema::hasTable('penalties')) {
            Schema::create('penalties', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('reason');
                $table->integer('count')->default(1);
                $table->json('details')->nullable();
                $table->timestamp('penalty_date');
                $table->timestamps();

                $table->index(['user_id', 'penalty_date']);
                $table->index('reason');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('penalties');
    }
};