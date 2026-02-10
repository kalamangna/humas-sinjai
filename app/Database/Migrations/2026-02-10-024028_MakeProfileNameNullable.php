<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeProfileNameNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('profiles', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('profiles', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
        ]);
    }
}