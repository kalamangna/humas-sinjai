<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();

        // Call individual seeders
        $this->call('UserSeeder');
        $this->call('CategorySeeder');
        $this->call('TagSeeder');
        $this->call('PostSeeder');

        $this->db->enableForeignKeyChecks();
    }
}