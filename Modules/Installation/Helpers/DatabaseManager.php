<?php

namespace Modules\Installation\Helpers;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\PermissionsController;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        $outputLog = new BufferedOutput;

        $this->sqlite($outputLog);

        Artisan::call('optimize:clear');
        if(file_exists(storage_path('w3cms.sql')))
        {
            $sql_dump = file_get_contents(storage_path('w3cms.sql'));
            DB::connection()->getPdo()->exec("SET FOREIGN_KEY_CHECKS=0");
            DB::connection()->getPdo()->exec($sql_dump);
            DB::connection()->getPdo()->exec("SET FOREIGN_KEY_CHECKS=1");
            Artisan::call('storage:link');
            Artisan::call('optimize:clear');
            return;
        }

        return $this->migrate($outputLog);
    }

    /**
     * Run the migration and call the seeder.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function migrate(BufferedOutput $outputLog)
    {
        app()->bootstrapWith([\Illuminate\Foundation\Bootstrap\LoadConfiguration::class]);
        try {
            Artisan::call('migrate:fresh', ['--force'=> true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->seed($outputLog);
    }

    /**
     * Seed the database.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function seed(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('db:seed', ['--force' => true], $outputLog);
            Artisan::call('module:seed', ['--force' => true], $outputLog);

            $permissionObj = new PermissionsController;
            $permissionObj->generate_permissions();
            $permissionObj->add_to_permissions();
            
            Artisan::call('optimize:clear');
            Artisan::call('storage:link');
            Artisan::call('route:clear');
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('installation::installer_messages.final.finished'), 'success', $outputLog);
    }

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function response($message, $status, BufferedOutput $outputLog)
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    /**
     * Check database type. If SQLite, then create the database file.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     */
    private function sqlite(BufferedOutput $outputLog)
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (! file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
            $outputLog->write('Using SqlLite database: '.$database, 1);
        }
    }
}
