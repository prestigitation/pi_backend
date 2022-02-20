<?php

namespace Database\Seeders;

use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Enums\EducationLevels;
use App\Helpers\Enums\Regalias;
use App\Repositories\FileRepository;
use Illuminate\Database\Seeder;

use App\Helpers\Enums\TeacherPositions;
use App\Models\EducationLevel;
use App\Models\Regalia;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

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

        $highEducation = EducationLevel::where('name', EducationLevels::LEVEL_HIGHER->value)->first()->id;

        $teachers = [
            [
                'proof_document_link' => 'some_link',
                'dissertation_proof' => '14.08.2008г. на кафедре высшей математики Универсального института инновационных технологий города Москвы защитила диссертацию на соискание ученой степени кандидата на тему «Риски и пути минимизации в деятельности коммерческих банков» по специальности «Экономика и управление народным хозяйством» (08.00.05)',
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'professional_interests' => 'Профессиональные и научные интересы:
                Разнообразный и богатый опыт укрепление и развитие структуры требуют от нас анализа модели развития. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.
                Не следует, однако забывать, что начало повседневной работы по формированию позиции требуют от нас анализа позиций, занимаемых участниками в отношении поставленных задач. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий позволяет оценить значение дальнейших направлений развития. Таким образом сложившаяся структура организации в значительной степени обуславливает создание новых предложений. Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности требуют определения и уточнения новых предложений.',
                'surname' => "Тягульская",
                'name' => "Людмила",
                'patronymic' => "Анатольевна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/tyagulska.png'),
                'additional_info' => [
                    'role' => array(DashboardRoles::ROLE_OWNER->value),
                    'regalias' => [
                        Regalia::where('name', Regalias::REGALIA_ECONOMY_CANDIDAT->value)->first()->id,
                        Regalia::where('name', Regalias::REGALIA_DEPARTMENT_OWNER->value)->first()->id,
                    ]
                ],
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Козак",
                'name' => "Людмила",
                'patronymic' => "Ярославовна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/kozak.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation,
                'additional_info' => [
                    'regalias' => [
                        Regalia::where('name', Regalias::REGALIA_TECH_CANDIDAT->value)->first()->id,
                    ]
                ],
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Балан",
                'name' => "Лилия",
                'patronymic' => "Александровна",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/balan.png'),
                'additional_info' => [
                    'regalias' => [
                        Regalia::where('name', Regalias::REGALIA_TEACHER_CANDIDAT->value)->first()->id,
                    ]
                ],
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Глазов",
                'name' => "Анатолий",
                'patronymic' => "Борисович",
                'position' => TeacherPositions::POSITION_DOCENT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/glazov.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Борсуковский",
                'name' => "Сергей",
                'patronymic' => "Иванович",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/borsukovskiy.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Ляху",
                'name' => "Александр",
                'patronymic' => "Анатольевич",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => '',
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Сташкова",
                'name' => "Ольга",
                'patronymic' => "Витальевна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/stashkova.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Шестопал",
                'name' => "Оксана",
                'patronymic' => "Викторовна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/shestopal.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Гарбузняк",
                'name' => "Елена",
                'patronymic' => "Сергеевна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/garbuzniak.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Кардаш",
                'name' => "Людмила",
                'patronymic' => "Федоровна",
                'position' => TeacherPositions::POSITION_SENIOR_LECTURER->value,
                'additional_info' => [
                    'regalias' => [
                        Regalia::where('name', Regalias::REGALIA_LEAD_SPECIALIST->value)->first()->id,
                    ]
                ],
                'avatar_path' => $this->fileRepository->getFileLink('teachers/kardash.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Нагаевский",
                'name' => "Октавиан",
                'patronymic' => "Михайлович",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/nagaevsky.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Нагаевская",
                'name' => "Наталья",
                'patronymic' => "Владимировна",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/nagaevskaya.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Борсуковский",
                'name' => "Сергей",
                'patronymic' => "Васильевич",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => '',
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Луценко",
                'name' => "Игорь",
                'patronymic' => "Владимирович",
                'position' => TeacherPositions::POSITION_ENGINEER->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/lucenko.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Станьковская",
                'name' => "Алёна",
                'patronymic' => "Александровна",
                'position' => TeacherPositions::POSITION_SENIOR_LABORANT->value,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/stankovskaya.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Пешкин",
                'name' => "Дана",
                'patronymic' => "Ильинична",
                'position' => TeacherPositions::POSITION_LECTURER->value,
                'avatar_path' => '',
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ]
            ];

            foreach($teachers as $teacher) {
                $newUser = User::create([
                    'name' => $teacher['name'],
                    'surname' => $teacher['surname'],
                    'patronymic' => $teacher['patronymic'],
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('123')
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

                $newTeacher = new Teacher;
                $newTeacher->user()->associate($newUser->id);
                $newTeacher->position = $teacher['position'];
                $newTeacher->avatar_path = $teacher['avatar_path'];
                $newTeacher->education_level_id = $teacher['education_level_id'];
                $newTeacher->publications_count = $teacher['publications_count'];
                $newTeacher->projects_count = $teacher['projects_count'];
                $newTeacher->conferences_count = $teacher['conferences_count'];
                $newTeacher->diploma_projects_count = $teacher['diploma_projects_count'];
                if(isset($teacher['education'])) $newTeacher->education = $teacher['education'];
                if(isset($teacher['proof_document_link'])) $newTeacher->proof_document_link = $teacher['proof_document_link'];
                if(isset($teacher['dissertation_proof'])) $newTeacher->dissertation_proof = $teacher['dissertation_proof'];
                if(isset($teacher['professional_interests'])) $newTeacher->professional_interests = $teacher['professional_interests'];
                $newTeacher->save();

                if(isset($teacher['additional_info']['regalias'])) {
                    foreach($teacher['additional_info']['regalias'] as $regalia) {
                        $newTeacher->regalias()->attach($regalia);
                    }
                }
            }
        }
    }
