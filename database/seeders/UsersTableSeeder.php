<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Auth\RegisterController;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controller = new RegisterController();
        DB::table('users')->where('email', 'admin@gmail.com')->delete();
        $controller->create([
            'name' => 'John',
            'surname' => 'D',
            'patronymic' => 'oe',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin',
        ]);
    }
}
