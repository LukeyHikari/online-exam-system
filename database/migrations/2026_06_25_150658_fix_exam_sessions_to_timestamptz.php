<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN started_at TYPE TIMESTAMPTZ
            USING started_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN submitted_at TYPE TIMESTAMPTZ
            USING submitted_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN created_at TYPE TIMESTAMPTZ
            USING created_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN updated_at TYPE TIMESTAMPTZ
            USING updated_at AT TIME ZONE 'UTC'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN started_at TYPE TIMESTAMP
            USING started_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN submitted_at TYPE TIMESTAMP
            USING submitted_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN created_at TYPE TIMESTAMP
            USING created_at AT TIME ZONE 'UTC'");

        DB::statement("ALTER TABLE exam_sessions
            ALTER COLUMN updated_at TYPE TIMESTAMP
            USING updated_at AT TIME ZONE 'UTC'");
    }
};