<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFullTextIndexToPosts extends Migration
{
    public function up()
    {
        // Add FULLTEXT index to title and content columns
        $this->db->query("ALTER TABLE posts ADD FULLTEXT INDEX fulltext_posts (title, content)");
    }

    public function down()
    {
        // Remove the FULLTEXT index
        $this->db->query("ALTER TABLE posts DROP INDEX fulltext_posts");
    }
}