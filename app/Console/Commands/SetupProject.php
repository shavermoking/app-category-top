<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databasePath = database_path('database.sqlite');
        if (!file_exists($databasePath)) {
            touch($databasePath);
            $this->info("Database file created at: {$databasePath}");
        }

        $this->runMigrations();

        $this->loadApiData();

    }

    private function runMigrations(): void
    {
        Artisan::call('migrate');
        $this->info(Artisan::output());
    }

    private function loadApiData(): void
    {
        $dateTo = Carbon::now()->format('Y-m-d');
        $dateFrom = Carbon::now()->subDays(29)->format('Y-m-d');

        Artisan::call('load:app-top-positions', [
            'applicationId' => 1421444,
            'countryId' => 1,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);

        $this->info(Artisan::output());
    }
}
