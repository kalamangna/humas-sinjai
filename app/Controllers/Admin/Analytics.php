<?php

namespace App\Controllers\Admin;

use App\Models\GoogleAnalyticsModel;

class Analytics extends BaseController
{
    protected $gaModel;

    public function __construct()
    {
        helper('date');
        $this->gaModel = new GoogleAnalyticsModel();
    }

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
            $data = $this->gaModel->getOverview();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function topPages()
    {
        try {
            $data = $this->gaModel->getTopPages(10);
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function trafficSources()
    {
        try {
            $data = $this->gaModel->getTrafficSources();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function geo()
    {
        try {
            $data = $this->gaModel->getGeoData();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function deviceCategory()
    {
        try {
            $data = $this->gaModel->getDeviceData();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function popularPosts()
    {
        try {
            $data = $this->gaModel->getPopularPosts();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function monthlyPostStats()
    {
        try {
            $data = $this->gaModel->getMonthlyPostStats();

            foreach ($data as &$item) {
                $item['formatted_date'] = format_date($item['year'] . '-' . $item['month'] . '-01', 'month_year');
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function monthlyUserStats()
    {
        try {
            $data = $this->gaModel->getMonthlyUserStats();

            foreach ($data as &$item) {
                $item['formatted_date'] = format_date($item['year'] . '-' . $item['month'] . '-01', 'month_year');
            }

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function monthlyReport($year = null, $month = null)
    {
        $postModel = new \App\Models\PostModel();

        if ($year === null || $month === null) {
            $year = date('Y');
            $month = date('m');
            return redirect()->to(base_url("admin/analytics/monthly-report/{$year}/{$month}"));
        }

        $data['posts'] = $postModel->getPostsByMonthYear($month, $year);
        $data['year'] = $year;
        $data['month'] = $month;
        $data['months'] = [];
        for ($m = 1; $m <= 12; $m++) {
            $data['months'][] = [
                'year' => $year,
                'month' => str_pad($m, 2, '0', STR_PAD_LEFT)
            ];
        }

        return $this->render('Admin/Analytics/monthly_report', $data);
    }

    public function monthlyReportPrint($year, $month)
    {
        $postModel = new \App\Models\PostModel();
        $data['posts'] = $postModel->getPostsByMonthYear($month, $year);
        $data['year'] = $year;
        $data['month'] = $month;

        return view('Admin/Analytics/monthly_report_print', $data);
    }

    protected function handleError(\Exception $e)
    {
        log_message('error', 'Google Analytics Error: ' . $e->getMessage());

        return $this->response->setJSON([
            'status' => 'error',
            'message' => trim(preg_replace('/\s+/', ' ', $e->getMessage())),
        ]);
    }
}
