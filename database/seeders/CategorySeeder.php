<?php

namespace Database\Seeders;

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
        $categories = [
            ['name' => 'Все новости'],
            ['name' => 'Учеба'],
            ['name' => 'Наука'],
            ['name' => 'Абитуриент'],
            ['name' => 'Новости'],
            ['name' => 'Новости группы'],
            ['name' => 'РФ ПГУ'],
            ['name' => 'И-новости'],
            ['name' => 'Обявления']
        ];

        foreach($categories as $category) {
            Category::create([
                'name' => $category['name']
            ]);
        }
    }
}
