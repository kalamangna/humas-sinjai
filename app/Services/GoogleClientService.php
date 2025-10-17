<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;

class GoogleClientService
{
    public static function getClient(): BetaAnalyticsDataClient
    {
        $credentialsPath = WRITEPATH . 'ga4-service-account.json';
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Google Analytics service account credentials file not found.');
        }

        return new BetaAnalyticsDataClient([
            'credentials' => $credentialsPath,
        ]);
    }

    public static function getPropertyId(): string
    {
        $propertyId = getenv('GA4_PROPERTY_ID');
        if (empty($propertyId)) {
            throw new \Exception('GA4_PROPERTY_ID is not set in .env file.');
        }

        return $propertyId;
    }
}
