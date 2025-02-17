<?php

namespace App\Contracts;

interface IAppTopCategory
{
    public function fetchAndSaveData(int $applicationId, int $countryId, string $dateFrom, string $dateTo): void;

}
