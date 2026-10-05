<?php
/**
 * Safe, read-only pre-flight database inspection script for Render deployment.
 * Never exposes passwords, secrets, or credential values.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== READ-ONLY DATABASE PRE-FLIGHT INSPECTION ===" . PHP_EOL;

try {
    $pdo = DB::connection('pgsql')->getPdo();
    echo "PostgreSQL Connection: SUCCESS" . PHP_EOL;

    // 1. Existing public tables
    $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename;");
    $tableNames = array_map(fn($t) => $t->tablename, $tables);
    echo "Existing public tables (" . count($tableNames) . "): " . implode(', ', $tableNames) . PHP_EOL;

    // 2. Migration history
    if (in_array('migrations', $tableNames)) {
        $migrations = DB::select("SELECT migration, batch FROM migrations ORDER BY batch, migration;");
        echo "Recorded migrations count: " . count($migrations) . PHP_EOL;
        foreach ($migrations as $m) {
            echo "  - [Batch {$m->batch}] {$m->migration}" . PHP_EOL;
        }

        $usersMig = DB::select("SELECT * FROM migrations WHERE migration = '0001_01_01_000000_create_users_table';");
        echo "0001_01_01_000000_create_users_table recorded: " . (count($usersMig) > 0 ? "YES" : "NO") . PHP_EOL;
    } else {
        echo "Migrations table: NOT YET CREATED" . PHP_EOL;
    }

    // 3. Users table inspection
    $usersTableExists = in_array('users', $tableNames);
    echo "Users table exists: " . ($usersTableExists ? "YES" : "NO") . PHP_EOL;

    if ($usersTableExists) {
        // Columns
        $columns = DB::select("SELECT column_name, data_type, is_nullable, column_default FROM information_schema.columns WHERE table_schema = 'public' AND table_name = 'users' ORDER BY ordinal_position;");
        echo "Users columns (" . count($columns) . "):" . PHP_EOL;
        foreach ($columns as $c) {
            echo "  - {$c->column_name} ({$c->data_type}, nullable: {$c->is_nullable})" . PHP_EOL;
        }

        // Constraints
        $constraints = DB::select("SELECT tc.constraint_name, tc.constraint_type FROM information_schema.table_constraints tc WHERE tc.table_schema = 'public' AND tc.table_name = 'users' ORDER BY tc.constraint_name;");
        echo "Users constraints (" . count($constraints) . "):" . PHP_EOL;
        foreach ($constraints as $con) {
            echo "  - {$con->constraint_name} ({$con->constraint_type})" . PHP_EOL;
        }

        // Indexes
        $indexes = DB::select("SELECT indexname, indexdef FROM pg_indexes WHERE schemaname = 'public' AND tablename = 'users' ORDER BY indexname;");
        echo "Users indexes (" . count($indexes) . "):" . PHP_EOL;
        foreach ($indexes as $idx) {
            echo "  - {$idx->indexname}" . PHP_EOL;
        }

        // Email row counts
        $emailStats = DB::select("SELECT COUNT(*) AS total_rows, COUNT(email) AS non_null_emails, COUNT(DISTINCT email) AS distinct_emails FROM users;");
        if (!empty($emailStats)) {
            $stat = $emailStats[0];
            echo "Users rows: {$stat->total_rows}, non-null emails: {$stat->non_null_emails}, distinct emails: {$stat->distinct_emails}" . PHP_EOL;
        }

        // Duplicate emails
        $duplicates = DB::select("SELECT email, COUNT(*) AS duplicate_count FROM users WHERE email IS NOT NULL GROUP BY email HAVING COUNT(*) > 1 ORDER BY duplicate_count DESC;");
        if (count($duplicates) > 0) {
            echo "WARNING: Duplicate emails detected: " . count($duplicates) . PHP_EOL;
        } else {
            echo "Duplicate emails: NONE (0 duplicates)" . PHP_EOL;
        }
    }

    echo "================================================" . PHP_EOL;
} catch (\Throwable $e) {
    echo "Pre-flight inspection warning: " . $e->getMessage() . PHP_EOL;
    echo "================================================" . PHP_EOL;
}
