<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\CategoryModel;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categoryModel = new CategoryModel();

        // Create "Program Prioritas" parent category
        $parentCategoryName = 'Program Prioritas';
        $parentCategorySlug = 'program-prioritas';

        if ($categoryModel->where('slug', $parentCategorySlug)->first() === null) {
            $categoryModel->save([
                'name' => $parentCategoryName,
                'slug' => $parentCategorySlug,
            ]);

            $parentId = $categoryModel->getInsertID();

            // Create child categories
            $childCategories = [
                'Pendidikan Berkualitas',
                'Kesehatan Terjangkau',
                'Infrastruktur Merata',
                'Ekonomi Kreatif',
                'Reformasi Birokrasi',
                'Lingkungan Hidup',
            ];

            foreach ($childCategories as $childCategoryName) {
                $childCategorySlug = strtolower(url_title($childCategoryName, '-', true));

                if ($categoryModel->where('slug', $childCategorySlug)->first() === null) {
                    $categoryModel->save([
                        'name'      => $childCategoryName,
                        'slug'      => $childCategorySlug,
                        'parent_id' => $parentId,
                    ]);
                }
            }
        }
    }
}