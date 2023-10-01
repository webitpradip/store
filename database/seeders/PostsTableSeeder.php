<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('posts')->insert([
            'title' => 'Sample Title',
            'description' => 'Sample long description...',
            'filelinks' => 'http://example.com',
            'groupname' => 'Sample Group',

        ]);
    }


}
