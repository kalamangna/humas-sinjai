<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\OrderBy;

class GoogleAnalyticsService
{
    protected $client;
    protected $propertyId;

    public function __construct()
    {
        $this->client = GoogleClientService::getClient();
        $this->propertyId = GoogleClientService::getPropertyId();
    }

    public function runReport(array $config = []): array
    {
        try {
            $request = new RunReportRequest([
                'property' => 'properties/' . $this->propertyId,
                'date_ranges' => $this->buildDateRanges($config['date_ranges'] ?? []),
                'dimensions' => $this->buildDimensions($config['dimensions'] ?? []),
                'metrics' => $this->buildMetrics($config['metrics'] ?? []),
                'order_bys' => $this->buildOrderBys($config['order_bys'] ?? []),
            ]);

            $response = $this->client->runReport($request);
            return $this->formatResponse($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Google Analytics API Error: ' . $e->getMessage());
        }
    }

    protected function buildDateRanges(array $dateRanges): array
    {
        if (empty($dateRanges)) {
            $dateRanges = [['start_date' => '28daysAgo', 'end_date' => 'today']];
        }

        $ranges = [];
        foreach ($dateRanges as $range) {
            $ranges[] = new DateRange($range);
        }
        return $ranges;
    }

    protected function buildDimensions(array $dimensions): array
    {
        $dimensionObjects = [];
        foreach ($dimensions as $dimension) {
            $dimensionObjects[] = new Dimension(['name' => $dimension]);
        }
        return $dimensionObjects;
    }

    protected function buildMetrics(array $metrics): array
    {
        $metricObjects = [];
        foreach ($metrics as $metric) {
            $metricObjects[] = new Metric(['name' => $metric]);
        }
        return $metricObjects;
    }

    protected function buildOrderBys(array $orderBys): array
    {
        $orderByObjects = [];
        foreach ($orderBys as $orderBy) {
            if (isset($orderBy['metric'])) {
                $orderByObjects[] = new OrderBy([
                    'metric' => new OrderBy\MetricOrderBy([
                        'metric_name' => $orderBy['metric']
                    ]),
                    'desc' => $orderBy['desc'] ?? true,
                ]);
            }
        }
        return $orderByObjects;
    }

    protected function formatResponse($response): array
    {
        $data = [];
        foreach ($response->getRows() as $row) {
            $item = [];

            // Process dimensions
            foreach ($row->getDimensionValues() as $index => $dimension) {
                $item['dimensions'][$index] = $dimension->getValue();
            }

            // Process metrics
            foreach ($row->getMetricValues() as $index => $metric) {
                $item['metrics'][$index] = $metric->getValue();
            }

            $data[] = $item;
        }

        return $data;
    }
}
