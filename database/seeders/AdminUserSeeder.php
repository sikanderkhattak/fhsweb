<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => "Admin", 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
       
            'status_id'=>1,

        ]);
    }
}
