<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategoryPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_post=array();
        for ($i=0; $i < 40; $i++) { 
            $category_post[]= array(
                'category_id' => rand(1,10),
                'post_id' => rand(1,20),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            );
        }

        DB::table('category_post')->insert($category_post);
    }
}
