<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddViewsToPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'views' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'after' => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'views');
    }
}
