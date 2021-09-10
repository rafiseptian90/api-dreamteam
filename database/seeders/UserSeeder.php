<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([
            [
                'username' => 'rshme',
                'email' => 'rshme@gmail.com',
                'password' => bcrypt('rshme!!')
            ]
        ]);

        $users->map(function($user){
            $user = User::create($user);

            Profile::create([
                'user_id' => $user->id,
                'name' => 'Rafi Septian Hadi',
                'gender' => 'M',
                'bio' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."
            ]);
        });
    }
}
