<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Administrador new_user
         */
        $new_user =  User::where('email', 'admin@admin.net')->first();
        if ($new_user) {
            $new_user->tokens()->delete();
            $new_user->forceDelete();
        }

        $new_user = [
            'user_id' => 'admin',
            'name' => 'new_user, S.A.',
            'dni' => 'J000000000',
            'email' => 'admin@admin.net',
            'password' => Hash::make('admin1234'),
            'email_verified_at' => '2021-05-10 10:30:45',
        ];

        $new_user = User::create($new_user);
        $new_user->assignRole('admin');
        
        unset($new_user);
        unset($new_user);
    }
}
