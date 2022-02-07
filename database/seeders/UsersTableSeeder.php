<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Helpers\Enums\DashboardRoles;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Role;

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
        $doe = $controller->create([
            'name' => 'John',
            'surname' => 'D',
            'patronymic' => 'oe',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);
        $doe->roles()->attach(DashboardRoles::getEnumModel(Role::class, DashboardRoles::ROLE_ADMIN));
    }
}
