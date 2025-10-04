<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCategoryIdFromPosts extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('posts', 'posts_category_id_foreign');
        $this->forge->dropColumn('posts', 'category_id');
    }

    public function down()
    {
        $this->forge->addColumn('posts', [
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'after'      => 'user_id', // Place it back where it was
            ],
        ]);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
    }
}