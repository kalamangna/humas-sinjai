<?php

namespace App\Controllers\Admin;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

class Analytics extends BaseController
{
    public function overviewView()
    {
        return $this->render('Admin/Analytics/overview');
    }

    public function topPagesView()
    {
        return $this->render('Admin/Analytics/top_pages');
    }

    public function trafficSourcesView()
    {
        return $this->render('Admin/Analytics/traffic_sources');
    }

    public function geoView()
    {
        return $this->render('Admin/Analytics/geo');
    }

    public function deviceCategoryView()
    {
        return $this->render('Admin/Analytics/device_category');
    }

    public function overview()
    {
        try {
            $propertyId = getenv('GA4_PROPERTY_ID');
            if (empty($propertyId)) {
                return $this->response->setStatusCode(500, 'GA4_PROPERTY_ID is not set in the .env file.');
            }

            $credentialsPath = WRITEPATH . 'ga4-service-account.json';
            if (!file_exists($credentialsPath)) {
                return $this->response->setStatusCode(500, 'Google Analytics service account credentials file not found.');
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . $propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                'metrics' => [
                    new Metric(['name' => 'totalUsers']),
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'bounceRate']),
                    new Metric(['name' => 'averageSessionDuration']),
                ],
            ]);

            $response = $client->runReport($request);

            $data = [];
            foreach ($response->getRows() as $row) {
                $data[] = [
                    'totalUsers' => $row->getMetricValues()[0]->getValue(),
                    'sessions' => $row->getMetricValues()[1]->getValue(),
                    'screenPageViews' => $row->getMetricValues()[2]->getValue(),
                    'bounceRate' => $row->getMetricValues()[3]->getValue(),
                    'averageSessionDuration' => $row->getMetricValues()[4]->getValue(),
                ];
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
            ]);
        }
    }

    public function topPages()
    {
        try {
            $propertyId = getenv('GA4_PROPERTY_ID');
            if (empty($propertyId)) {
                return $this->response->setStatusCode(500, 'GA4_PROPERTY_ID is not set in the .env file.');
            }

            $credentialsPath = WRITEPATH . 'ga4-service-account.json';
            if (!file_exists($credentialsPath)) {
                return $this->response->setStatusCode(500, 'Google Analytics service account credentials file not found.');
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . $propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'pageTitle']),
                    new Dimension(['name' => 'pagePath']),
                ],
                'metrics' => [
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'userEngagementDuration']),
                ],
                'order_bys' => [
                    new \Google\Analytics\Data\V1beta\OrderBy([
                        'metric' => new \Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy([
                            'metric_name' => 'screenPageViews',
                        ]),
                        'desc' => true,
                    ]),
                ],
                'limit' => 10,
            ]);

            $response = $client->runReport($request);

            $data = [];
            foreach ($response->getRows() as $row) {
                $data[] = [
                    'pageTitle' => $row->getDimensionValues()[0]->getValue(),
                    'pagePath' => $row->getDimensionValues()[1]->getValue(),
                    'screenPageViews' => $row->getMetricValues()[0]->getValue(),
                    'userEngagementDuration' => $row->getMetricValues()[1]->getValue(),
                ];
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
            ]);
        }
    }

    public function trafficSources()
    {
        try {
            $propertyId = getenv('GA4_PROPERTY_ID');
            if (empty($propertyId)) {
                return $this->response->setStatusCode(500, 'GA4_PROPERTY_ID is not set in the .env file.');
            }

            $credentialsPath = WRITEPATH . 'ga4-service-account.json';
            if (!file_exists($credentialsPath)) {
                return $this->response->setStatusCode(500, 'Google Analytics service account credentials file not found.');
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . $propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'sessionSource']),
                    new Dimension(['name' => 'sessionMedium']),
                ],
                'metrics' => [
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'newUsers']),
                    new Metric(['name' => 'screenPageViews']),
                ],
            ]);

            $response = $client->runReport($request);

            $data = [];
            foreach ($response->getRows() as $row) {
                $data[] = [
                    'sessionSource' => $row->getDimensionValues()[0]->getValue(),
                    'sessionMedium' => $row->getDimensionValues()[1]->getValue(),
                    'sessions' => $row->getMetricValues()[0]->getValue(),
                    'newUsers' => $row->getMetricValues()[1]->getValue(),
                    'screenPageViews' => $row->getMetricValues()[2]->getValue(),
                ];
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
            ]);
        }
    }

    public function geo()
    {
        try {
            $propertyId = getenv('GA4_PROPERTY_ID');
            if (empty($propertyId)) {
                return $this->response->setStatusCode(500, 'GA4_PROPERTY_ID is not set in the .env file.');
            }

            $credentialsPath = WRITEPATH . 'ga4-service-account.json';
            if (!file_exists($credentialsPath)) {
                return $this->response->setStatusCode(500, 'Google Analytics service account credentials file not found.');
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . $propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'country']),
                    new Dimension(['name' => 'region']),
                    new Dimension(['name' => 'city']),
                ],
                'metrics' => [
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'activeUsers']),
                ],
            ]);

            $response = $client->runReport($request);

            $data = [];
            foreach ($response->getRows() as $row) {
                $data[] = [
                    'country' => $row->getDimensionValues()[0]->getValue(),
                    'region' => $row->getDimensionValues()[1]->getValue(),
                    'city' => $row->getDimensionValues()[2]->getValue(),
                    'sessions' => $row->getMetricValues()[0]->getValue(),
                    'activeUsers' => $row->getMetricValues()[1]->getValue(),
                ];
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
            ]);
        }
    }

    public function deviceCategory()
    {
        try {
            $propertyId = getenv('GA4_PROPERTY_ID');
            if (empty($propertyId)) {
                return $this->response->setStatusCode(500, 'GA4_PROPERTY_ID is not set in the .env file.');
            }

            $credentialsPath = WRITEPATH . 'ga4-service-account.json';
            if (!file_exists($credentialsPath)) {
                return $this->response->setStatusCode(500, 'Google Analytics service account credentials file not found.');
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . $propertyId,
                'date_ranges' => [
                    new DateRange([
                        'start_date' => '7daysAgo',
                        'end_date'   => 'today',
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'deviceCategory']),
                    new Dimension(['name' => 'operatingSystem']),
                    new Dimension(['name' => 'browser']),
                ],
                'metrics' => [
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'averageSessionDuration']),
                ],
            ]);

            $response = $client->runReport($request);

            $data = [];
            foreach ($response->getRows() as $row) {
                $data[] = [
                    'deviceCategory' => $row->getDimensionValues()[0]->getValue(),
                    'operatingSystem' => $row->getDimensionValues()[1]->getValue(),
                    'browser' => $row->getDimensionValues()[2]->getValue(),
                    'sessions' => $row->getMetricValues()[0]->getValue(),
                    'screenPageViews' => $row->getMetricValues()[1]->getValue(),
                    'averageSessionDuration' => $row->getMetricValues()[2]->getValue(),
                ];
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
            ]);
        }
    }
}
