<?php

namespace App\Models;

use App\Services\GoogleAnalyticsService;
use CodeIgniter\Model;

class GoogleAnalyticsModel extends Model
{
    protected $gaService;

    public function __construct()
    {
        $this->gaService = new GoogleAnalyticsService();
    }

    public function getOverview(): array
    {
        $data = $this->gaService->runReport([
            'metrics' => [
                'totalUsers',
                'newUsers',
                'sessions',
                'screenPageViews',
                'bounceRate',
                'averageSessionDuration'
            ],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'totalUsers' => (int)($item['metrics'][0] ?? 0),
                'newUsers' => (int)($item['metrics'][1] ?? 0),
                'sessions' => (int)($item['metrics'][2] ?? 0),
                'screenPageViews' => (int)($item['metrics'][3] ?? 0),
                'bounceRate' => (float)($item['metrics'][4] ?? 0),
                'averageSessionDuration' => (float)($item['metrics'][5] ?? 0),
            ];
        }, $data);
    }

    public function getTopPages(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['pageTitle', 'pagePath'],
            'metrics' => ['screenPageViews', 'userEngagementDuration'],
            'order_bys' => [['metric' => 'screenPageViews', 'desc' => true]],
        ]);

        // map array ke format yang diinginkan
        $mappedData = array_map(function ($item) {
            return [
                'pageTitle' => $item['dimensions'][0] ?? 'No Title',
                'pagePath' => $item['dimensions'][1] ?? '',
                'screenPageViews' => (int)($item['metrics'][0] ?? 0),
                'userEngagementDuration' => (float)($item['metrics'][1] ?? 0),
            ];
        }, $data);

        // exclude if path contain /login atau /index.php atau halaman admin
        $filteredData = array_filter($mappedData, function ($item) {
            $excludedPaths = [
                '/login',
                '/index.php',
                '/admin',
                '/api',
                '/v1/admin'
            ];

            foreach ($excludedPaths as $excludedPath) {
                if (str_contains($item['pagePath'], $excludedPath)) {
                    return false;
                }
            }
            return true;
        });

        // only include path with /v1
        $filteredData = array_filter($filteredData, function ($item) {
            return str_starts_with($item['pagePath'], '/v1');
        });

        // Apply limit setelah filtering
        return array_slice($filteredData, 0, 10);
    }

    public function getTrafficSources(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['sessionSource', 'sessionMedium'],
            'metrics' => ['sessions', 'newUsers', 'screenPageViews'],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'sessionSource' => $item['dimensions'][0] ?? 'Unknown',
                'sessionMedium' => $item['dimensions'][1] ?? 'Unknown',
                'sessions' => (int)($item['metrics'][0] ?? 0),
                'newUsers' => (int)($item['metrics'][1] ?? 0),
                'screenPageViews' => (int)($item['metrics'][2] ?? 0),
            ];
        }, $data);
    }

    public function getGeoData(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['country', 'region', 'city'],
            'metrics' => ['sessions', 'activeUsers'],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'country' => $item['dimensions'][0] ?? 'Unknown',
                'region' => $item['dimensions'][1] ?? 'Unknown',
                'city' => $item['dimensions'][2] ?? 'Unknown',
                'sessions' => (int)($item['metrics'][0] ?? 0),
                'activeUsers' => (int)($item['metrics'][1] ?? 0),
            ];
        }, $data);
    }

    public function getDeviceData(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['deviceCategory', 'operatingSystem', 'browser'],
            'metrics' => ['sessions', 'screenPageViews', 'averageSessionDuration'],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'deviceCategory' => $item['dimensions'][0] ?? 'Unknown',
                'operatingSystem' => $item['dimensions'][1] ?? 'Unknown',
                'browser' => $item['dimensions'][2] ?? 'Unknown',
                'sessions' => (int)($item['metrics'][0] ?? 0),
                'screenPageViews' => (int)($item['metrics'][1] ?? 0),
                'averageSessionDuration' => (float)($item['metrics'][2] ?? 0),
            ];
        }, $data);
    }

    public function getPopularPosts(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['pageTitle', 'pagePath'],
            'metrics' => ['screenPageViews'],
            'order_bys' => [['metric' => 'screenPageViews', 'desc' => true]],
        ]);

        // Map array ke format yang diinginkan
        $data = array_map(function ($item) {
            return [
                'title' => $item['dimensions'][0] ?? '',
                'path' => $item['dimensions'][1] ?? '',
                'views' => (int)($item['metrics'][0] ?? 0),
            ];
        }, $data);

        // Filter hanya post dengan path /v1/post/
        $filteredData = array_filter($data, function ($item) {
            return str_starts_with($item['path'], '/v1/post/');
        });

        // Limit 5 data teratas
        return array_slice($filteredData, 0, 5);
    }


    public function getMonthlyPostStats(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['year', 'month'],
            'metrics' => ['screenPageViews'],
            'order_bys' => [
                ['dimension' => 'year', 'desc' => true],
                ['dimension' => 'month', 'desc' => true],
            ],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'year' => $item['dimensions'][0] ?? 'Unknown',
                'month' => $item['dimensions'][1] ?? 'Unknown',
                'screenPageViews' => (int)($item['metrics'][0] ?? 0),
            ];
        }, $data);
    }

    public function getMonthlyUserStats(): array
    {
        $data = $this->gaService->runReport([
            'dimensions' => ['year', 'month'],
            'metrics' => ['totalUsers'],
            'order_bys' => [
                ['dimension' => 'year', 'desc' => true],
                ['dimension' => 'month', 'desc' => true],
            ],
        ]);

        // Map array ke format yang diinginkan
        return array_map(function ($item) {
            return [
                'year' => $item['dimensions'][0] ?? 'Unknown',
                'month' => $item['dimensions'][1] ?? 'Unknown',
                'totalUsers' => (int)($item['metrics'][0] ?? 0),
            ];
        }, $data);
    }

    public function getViewsBySlug(array $slugs = []): array
    {
        if (empty($slugs)) return [];

        $response = $this->gaService->runReport([
            'dimensions' => ['pagePath'],
            'metrics' => ['screenPageViews'],
            'date_ranges' => [['start_date' => '30daysAgo', 'end_date' => 'today']],
        ]);

        $views = [];
        foreach ($response as $row) {
            $path = $row['dimensions'][0] ?? '';
            $count = $row['metrics'][0] ?? 0;

            foreach ($slugs as $slug) {
                if (str_contains($path, '/post/' . $slug)) {
                    $views[$slug] = (int)$count;
                }
            }
        }

        return $views;
    }
}
