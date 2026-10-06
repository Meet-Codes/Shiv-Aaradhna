<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthCheckController extends Controller
{
    public function check(): JsonResponse
    {
        $status = 'healthy';
        $checks = [];

        // Check app key
        $key = config('app.key');
        $checks['app_key'] = !empty($key) ? 'configured' : 'missing';
        if (empty($key)) {
            $status = 'unhealthy';
        }

        // Check app storage writability
        $storageWritable = is_writable(storage_path());
        $checks['storage'] = $storageWritable ? 'writable' : 'read-only';
        if (!$storageWritable) {
            $status = 'degraded';
        }

        // Check database connection & driver
        try {
            DB::connection()->getPdo();
            $driver = DB::connection()->getDriverName();
            $tables = [];
            foreach (['users', 'categories', 'products', 'cms_sections', 'migrations'] as $table) {
                try {
                    $tables[$table] = DB::getSchemaBuilder()->hasTable($table);
                } catch (Throwable) {
                    $tables[$table] = false;
                }
            }

            $checks['database'] = [
                'status' => 'connected',
                'driver' => $driver,
                'tables' => $tables,
            ];
        } catch (Throwable $e) {
            $status = 'unhealthy';
            $checks['database'] = [
                'status' => 'disconnected',
                'driver' => config('database.default'),
                'error' => $e->getMessage(),
            ];
        }

        return response()->json([
            'status' => $status,
            'timestamp' => now()->toIso8601String(),
            'app' => config('app.name'),
            'environment' => config('app.env'),
            'checks' => $checks,
        ], $status === 'healthy' ? 200 : 503);
    }
}
