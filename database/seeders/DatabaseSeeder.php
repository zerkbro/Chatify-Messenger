<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $i =1;


        // For Seeding The users
        for($i=1;$i<9;$i++){
            $user = User::create([
                'name' => 'Simple User '.$i,
                'email' => 'user'.$i.'@user.com',
                'password' => bcrypt('password'),
                // 'role' => 'user',
                'profile_image' => 'default_pp.png',
                'profile_image_path' =>'talkster/default_pp.png',
            ]);

            $user->assignRole(['name'=>'user']);
        }
        // for($i=10;$i<19;$i++){
        //     $user = User::create([
        //         'name' => 'Simple admin '.$i,
        //         'email' => 'admin'.$i.'@admin.com',
        //         'password' => bcrypt('password'),
        //         // 'role' => 'admin',
        //     ]);

        //     $user->assignRole(['name'=>'admin']);
        // }
    }
}
