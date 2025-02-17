<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\IAppTopCategory;
use GuzzleHttp\Client;
use App\Models\AppTopPosition;

class AppTopCategoryService implements IAppTopCategory
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.apptica.api_host');
        $this->apiKey = config('services.apptica.api_key');
    }

    public function fetchAndSaveData(int $applicationId, int $countryId, string $dateFrom, string $dateTo): void
    {
        $data = $this->fetchDataFromApi($applicationId, $countryId, $dateFrom, $dateTo);

        foreach ($data['data'] as $category => $subcategories) {
            foreach ($subcategories as $subcategory => $dates) {
                if ($subcategory !== 1) {
                    continue;
                }

                foreach ($dates as $date => $position) {
                    if ($position === null) {
                        continue;
                    }

                    $this->savePosition(
                        $applicationId,
                        $countryId,
                        (string) $date,
                        (int) $category,
                        (int) $position
                    );
                }
            }
        }
    }

    private function fetchDataFromApi(int $applicationId, int $countryId, string $dateFrom, string $dateTo): array
    {
        $url = "{$this->baseUrl}{$applicationId}/{$countryId}?date_from={$dateFrom}&date_to={$dateTo}&B4NKGg={$this->apiKey}";

        $client = new Client();
        $response = $client->get($url);
        return json_decode((string) $response->getBody(), true);
    }

    private function savePosition(
        int $applicationId,
        int $countryId,
        string $date,
        int $category,
        int $position
    ): void {
        AppTopPosition::query()->updateOrCreate(
            [
                'application_id' => $applicationId,
                'country_id' => $countryId,
                'date' => $date,
                'category' => $category,
            ],
            ['position' => $position]
        );
    }
}
