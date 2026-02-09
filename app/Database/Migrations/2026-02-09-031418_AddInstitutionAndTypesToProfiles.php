<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInstitutionAndTypesToProfiles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('profiles', [
            'institution' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'position',
            ],
        ]);

        $this->forge->modifyColumn('profiles', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['bupati', 'wakil-bupati', 'sekda', 'forkopimda', 'eselon-ii', 'eselon-iii'],
                'default'    => 'forkopimda',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('profiles', 'institution');
        // Note: modifyColumn down might fail if data exists that doesn't match the old constraint, but for now this is acceptable.
        $this->forge->modifyColumn('profiles', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['bupati', 'wakil-bupati', 'sekda', 'forkopimda'],
                'default'    => 'forkopimda',
            ],
        ]);
    }
}