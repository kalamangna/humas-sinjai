<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTitleAndDescriptionFromCarouselSlides extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('carousel_slides', ['title', 'description']);
    }

    public function down()
    {
        $this->forge->addColumn('carousel_slides', [
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }
}
