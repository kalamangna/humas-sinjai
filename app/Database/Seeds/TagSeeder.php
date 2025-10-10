<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\TagModel;
use Faker\Factory;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tagModel = new TagModel();
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $name = $faker->unique()->word;
            $slug = strtolower(url_title($name, '-', true));

            if ($tagModel->where('slug', $slug)->first() === null) {
                $tagModel->save([
                    'name' => $name,
                    'slug' => $slug,
                ]);
            }
        }
    }
}