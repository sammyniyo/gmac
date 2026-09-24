<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportGmacDump extends Command
{
    protected $signature = 'db:import-gmac-dump {--path=database/data/gmac-from-sqlite.sql}';

    protected $description = 'Import the saved SQLite catalog into the current MySQL database without dropping the schema.';

    public function handle(): int
    {
        $path = base_path((string) $this->option('path'));

        if (! File::isFile($path)) {
            $this->error('Dump not found: '.$path);

            return self::FAILURE;
        }

        DB::unprepared(File::get($path));
        $this->info('Imported '.$path.' into '.config('database.default'));

        return self::SUCCESS;
    }
}
