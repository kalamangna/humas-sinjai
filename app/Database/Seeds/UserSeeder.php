<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel; // Import the UserModel

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel(); // Instantiate the model

        $usersData = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@sinjaikab.go.id',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Humas Sinjai',
                'email'    => 'humas@sinjaikab.go.id',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'author',
            ],
        ];

        foreach ($usersData as $userData) {
            // Check if user already exists by email
            if ($userModel->where('email', $userData['email'])->first() === null) {
                $userModel->save($userData); // Use save() to trigger timestamps
            }
        }
    }
}
