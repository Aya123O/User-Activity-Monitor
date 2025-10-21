<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_system_settings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('system_settings')->insert([
            [
                'key' => 'idle_timeout',
                'value' => '5',
                'description' => 'Idle timeout in seconds before showing alert',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'idle_warning_timeout',
                'value' => '10',
                'description' => 'Idle timeout in seconds before showing warning',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'idle_logout_timeout',
                'value' => '15',
                'description' => 'Idle timeout in seconds before automatic logout',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'activity_monitoring_enabled',
                'value' => 'true',
                'description' => 'Enable/disable activity monitoring',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'inactivity_penalty_enabled',
                'value' => 'true',
                'description' => 'Enable/disable inactivity penalties',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};