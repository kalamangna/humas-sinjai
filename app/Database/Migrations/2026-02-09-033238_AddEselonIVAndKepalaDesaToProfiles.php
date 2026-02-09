<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEselonIVAndKepalaDesaToProfiles extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('profiles', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['bupati', 'wakil-bupati', 'sekda', 'forkopimda', 'eselon-ii', 'eselon-iii', 'eselon-iv', 'kepala-desa'],
                'default'    => 'forkopimda',
            ],
        ]);
    }

    public function down()
    {
        // Reverting to previous state might be risky if data exists, but adhering to structure.
        $this->forge->modifyColumn('profiles', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['bupati', 'wakil-bupati', 'sekda', 'forkopimda', 'eselon-ii', 'eselon-iii'],
                'default'    => 'forkopimda',
            ],
        ]);
    }
}