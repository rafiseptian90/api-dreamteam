<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'name' => "PHP",
                'icon' => 'tags/php.png'
            ],
            [
                'name' => "Python",
                'icon' => 'tags/python.png'
            ],
            [
                'name' => "Golang",
                'icon' => 'tags/golang.png'
            ],
            [
                'name' => "Javascript",
                'icon' => 'tags/javascript.png'
            ],
            [
                'name' => "Laravel",
                'icon' => 'tags/laravel.png'
            ],
            [
                'name' => "CodeIgniter",
                'icon' => 'tags/codeigniter.png'
            ],
            [
                'name' => "Gin Gonic",
                'icon' => 'tags/gin-gonic.png'
            ],
            [
                'name' => "VueJS",
                'icon' => 'tags/vue-js.png'
            ],
            [
                'name' => "ReactJS",
                'icon' => 'tags/react-js.png'
            ],
            [
                'name' => "AngularJS",
                'icon' => 'tags/angular-js.png'
            ],
        ];


        foreach($tags as $tag){
            Tag::create($tag);
        }
    }
}
