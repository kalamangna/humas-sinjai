<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailCaptionToPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'thumbnail_caption' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'thumbnail',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'thumbnail_caption');
    }
}
