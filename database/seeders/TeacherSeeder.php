<?php

namespace Database\Seeders;

use App\Helpers\Enums\DashboardRoles;
use App\Repositories\FileRepository;
use Illuminate\Database\Seeder;

use App\Helpers\Enums\TeacherPositions;

use App\Models\User;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

use Faker\Generator as Faker;

class TeacherSeeder extends Seeder
{
    private $fileRepository;
    private $teacherRepository;
    private $userRepository;

    public function __construct(
        FileRepository $fileRepository,
        TeacherRepository $teacherRepository,
        UserRepository $userRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->teacherRepository = $teacherRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // Роли, которые будут дополнительно привязаны для большего функционала
        $additionalTeachersRoles = [
            TeacherPositions::POSITION_SENIOR_LABORANT->value,
            TeacherPositions::POSITION_ENGINEER->value,
        ];

        $teachers = [
            [
                'surname' => "Тягульская",
                'name' => "Людмила",
                'patronymic' => "Анатольевна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/tyagulska.png'),
                'additional_info' => [
                    'role' => [DashboardRoles::ROLE_OWNER->value]
                ]
            ],
            [
                'surname' => "Козак",
                'name' => "Людмила",
                'patronymic' => "Ярославовна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/kozak.png'),
            ],
            [
                'surname' => "Балан",
                'name' => "Лилия",
                'patronymic' => "Александровна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/balan.png'),
            ],
            [
                'surname' => "Глазов",
                'name' => "Анатолий",
                'patronymic' => "Борисович",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/glazov.png'),
            ],
            [
                'surname' => "Борсуковский",
                'name' => "Сергей",
                'patronymic' => "Иванович",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/borsukovskiy.png'),
            ],
            [
                'surname' => "Ляху",
                'name' => "Александр",
                'patronymic' => "Анатольевич",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => '',
            ],
            [
                'surname' => "Сташкова",
                'name' => "Ольга",
                'patronymic' => "Витальевна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/stashkova.png'),
            ],
            [
                'surname' => "Шестопал",
                'name' => "Оксана",
                'patronymic' => "Викторовна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/shestopal.png'),
            ],
            [
                'surname' => "Гарбузняк",
                'name' => "Елена",
                'patronymic' => "Сергеевна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/garbuzniak.png'),
            ],
            [
                'surname' => "Кардаш",
                'name' => "Людмила",
                'patronymic' => "Федоровна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/kardash.png'),
            ],
            [
                'surname' => "Нагаевский",
                'name' => "Октавиан",
                'patronymic' => "Михайлович",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/nagaevsky.png'),
            ],
            [
                'surname' => "Нагаевская",
                'name' => "Наталья",
                'patronymic' => "Владимировна",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/nagaevskaya.png'),
            ],
            [
                'surname' => "Борсуковский",
                'name' => "Сергей",
                'patronymic' => "Васильевич",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => '',
            ],
            [
                'surname' => "Луценко",
                'name' => "Игорь",
                'patronymic' => "Владимирович",
                'position' => TeacherPositions::POSITION_ENGINEER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/lucenko.png'),
            ],
            [
                'surname' => "Станьковская",
                'name' => "Алёна",
                'patronymic' => "Александровна",
                'position' => TeacherPositions::POSITION_SENIOR_LABORANT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/stankovskaya.png'),
            ],
            [
                'surname' => "Пешкин",
                'name' => "Дана",
                'patronymic' => "Ильинична",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => '',
            ],
            ];

            foreach($teachers as $teacher) {
                $newUser = User::create([
                    'name' => $teacher['name'],
                    'surname' => $teacher['surname'],
                    'patronymic' => $teacher['patronymic'],
                    'email' => $faker->unique()->safeEmail,
                    'password' => '123'
                ]);

                if(isset($teacher['additional_info']['role'])) {
                    foreach($teacher['additional_info']['role'] as $role) {
                        $additionalTeacherRoleId =  $this->teacherRepository->switchRoles($role);
                        $this->userRepository->setRole($newUser->id, $additionalTeacherRoleId);
                    }
                }

                $teacherRoleId = $this->teacherRepository->switchRoles(null);

                $this->userRepository->setRole($newUser->id, $teacherRoleId);

                $roleId = $this->teacherRepository->switchRoles($teacher['position']);

                if(in_array($teacher['position'], $additionalTeachersRoles)) {
                    // если преподаватель имеет дополнительный функционал(инженер, лаборант), привязываем еще 1 роль
                    $this->userRepository->setRole($newUser->id, $roleId);
                }

                DB::insert('INSERT INTO `teachers` (user_id, position, avatar_path) VALUES (?,?,?)', [$newUser->id, $teacher['position'], $teacher['avatar_path'] ?? null]);
            }
        }
    }
