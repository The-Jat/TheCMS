<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the database using a custom SQL script';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop all tables in the database
        $this->dropAllTables();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Path to your SQL script
        $sqlScriptPath = storage_path('db-reset-sql.sql');

        // Run the SQL script using Laravel's DB facade
        DB::unprepared(file_get_contents($sqlScriptPath));

        $this->info('Database reset successfully.');
    }

    // Function to drop all tables in the database
    protected function dropAllTables()
    {
        $tables = DB::select('SHOW TABLES');
        
        foreach ($tables as $table) {
            $tableName = reset($table);
            DB::statement("DROP TABLE IF EXISTS $tableName");
        }
    }
}
