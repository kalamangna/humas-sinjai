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

    public function downloadMonthlyReportPdf($year, $month)
    {
        // Increase limits for large PDF generation
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $postModel = new \App\Models\PostModel();
        $data['posts'] = $postModel->getPostsByMonthYear($month, $year);

        // Pre-process images to use local paths
        foreach ($data['posts'] as &$post) {
            // Process Thumbnail
            if (!empty($post['thumbnail'])) {
                $post['thumbnail_path'] = $this->localPathFromUrl($post['thumbnail']);
            }

            // Process Content Images
            $post['content'] = preg_replace_callback('/<img[^>]+src="([^">]+)"/', function($matches) {
                $src = $matches[1];
                $localPath = $this->localPathFromUrl($src);
                
                if ($localPath && file_exists($localPath)) {
                    return str_replace($src, $localPath, $matches[0]);
                }
                return $matches[0];
            }, $post['content']);
        }

        $data['year'] = $year;
        $data['month'] = $month;

        // Load logo and convert to base64 to avoid HTTP requests (prevents deadlock on single-threaded servers)
        $logoPath = FCPATH . 'logo.png';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $data['logo_base64'] = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            $data['logo_base64'] = null;
        }

        $html = view('Admin/Analytics/monthly_report_print', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false); // Disable remote to prevent deadlocks
        $options->set('defaultFont', 'Helvetica');
        $options->set('chroot', FCPATH); // Allow access to public folder

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Laporan-Bulanan-' . $year . '-' . $month . '.pdf';

        return $this->response->setHeader('Content-Type', 'application/pdf')
                              ->setBody($dompdf->output())
                              ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function localPathFromUrl($url)
    {
        $baseUrl = base_url();
        // Remove protocol and domain if present
        if (strpos($url, $baseUrl) === 0) {
            $relativePath = substr($url, strlen($baseUrl));
            // Ensure no leading slash issues if base_url has one and path has one
            $relativePath = ltrim($relativePath, '/');
            return FCPATH . $relativePath;
        }
        
        // If it's already a relative path (e.g. 'uploads/...')
        if (strpos($url, 'http') !== 0) {
             return FCPATH . ltrim($url, '/');
        }

        return null;
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
