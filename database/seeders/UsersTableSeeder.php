<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Helpers\Enums\DashboardRoles;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Role;
use App\Repositories\UserRepository;

class UsersTableSeeder extends Seeder
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
            'password' => 'hD2PsU5pEnYJ',
        ]);
        $this->userRepository->setRole($doe->id, Role::where('name', DashboardRoles::ROLE_ADMIN->value)->first()->id);
    }
}
