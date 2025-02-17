<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\IAppTopCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class LoadAppTopPositions extends Command
{
    protected $signature = 'load:app-top-positions {applicationId} {countryId} {dateFrom} {dateTo}';
    protected $description = 'Load app top positions from external API';

    private IAppTopCategory $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = App::make(IAppTopCategory::class);
    }

    public function handle(): void
    {
        $applicationId = (int) $this->argument('applicationId');
        $countryId = (int) $this->argument('countryId');
        $dateFrom = (string) $this->argument('dateFrom');
        $dateTo = (string) $this->argument('dateTo');

        $this->service->fetchAndSaveData($applicationId, $countryId, $dateFrom, $dateTo);
        $this->info('Data loaded successfully.');
    }
}
