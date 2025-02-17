<?php

namespace App\Console\Commands;

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
        Artisan::call('load:app-top-positions', [
            'applicationId' => 1421444,
            'countryId' => 1,
            'dateFrom' => '2025-01-19',
            'dateTo' => '2025-01-19'
        ]);
        $this->info(Artisan::output());
    }
}
