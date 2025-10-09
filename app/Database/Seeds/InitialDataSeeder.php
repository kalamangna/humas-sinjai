<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\CategoryModel;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Create a default user
        $userModel = new UserModel();
        $userModel->save([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'admin',
        ]);

        // Create some categories
        $categoryModel = new CategoryModel();
        $categoryModel->save([
            'name' => 'Berita',
            'slug' => 'berita',
        ]);

        $beritaId = $categoryModel->getInsertID();

        $categoryModel->save([
            'name' => 'Pemerintahan',
            'slug' => 'pemerintahan',
            'parent_id' => $beritaId,
        ]);

        $categoryModel->save([
            'name' => 'Masyarakat',
            'slug' => 'masyarakat',
            'parent_id' => $beritaId,
        ]);

        $categoryModel->save([
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
        ]);
    }
}
