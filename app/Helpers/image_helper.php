<?php

if (!function_exists('processImage')) {
    function processImage($file)
    {
        $image = \Config\Services::image()
            ->withFile($file)
            ->fit(1200, 630, 'center')
            ->convert(IMAGETYPE_WEBP);

        $tempPath = WRITEPATH . 'uploads/' . uniqid() . '.webp';

        // Iteratively reduce quality to meet file size target
        $quality = 85;
        do {
            $image->save($tempPath, $quality);
            $fileSize = filesize($tempPath);
            $quality -= 5;
        } while ($fileSize > 300 * 1024 && $quality >= 50);

        return $tempPath;
    }
}
