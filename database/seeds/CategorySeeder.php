<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'=>'laptop'
        ]);
        Category::create([
            'name'=>'car'
        ]);
        Category::create([
            'name'=>'phone'
        ]);
        Category::create([
            'name'=>'desktop'
        ]);
        Category::create([
            'name'=>'tv'
        ]);
        Category::create([
            'name'=>'watch'
        ]);
        Category::create([
            'name'=>'clothes'
        ]);
        Category::create([
            'name'=>'cycle'
        ]);
        Category::create([
            'name'=>'ssd'
        ]);
        Category::create([
            'name'=>'tablet'
        ]);
    }
}
