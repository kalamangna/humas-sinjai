<?php

if (!function_exists('processImage')) {
    function processImage($file)
    {
        $image = \Config\Services::image()
            ->withFile($file)
            ->fit(1200, 630, 'center')
            ->convert(IMAGETYPE_PNG);

        $tempPath = WRITEPATH . 'uploads/' . uniqid() . '.png';
        $image->save($tempPath, 80); // Compress with quality 80%

        $fileSize = filesize($tempPath);
        if ($fileSize > 300 * 1024) {
            // Further compression if needed
            $image->save($tempPath, 60);
        }

        return $tempPath;
    }
}
