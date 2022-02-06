<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Helpers\Enums\NewsCategories;
use App\Helpers\Traits\EnumHelper;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        foreach(EnumHelper::getValues(NewsCategories::cases()) as $index => $role) {
            Category::create([
                'id' => $index + 1,
                'name' => $role
            ]);
        }
    }
}
