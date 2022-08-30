<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Tracker\Support\Migration;

class AddTrackerLanguageForeignKeyToSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp()
    {
        if (!Schema::hasTable('tracker_sessions')) {
            $this->builder->table('tracker_sessions', function ($table) {
                $table->foreign('language_id')
                    ->references('id')
                    ->on('tracker_languages')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown()
    {
        $this->builder->table('tracker_sessions', function ($table) {
            $table->dropForeign(['language_id']);
        });
    }
}
