<?php

namespace Database\Seeders;

use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Enums\EducationLevels;
use App\Helpers\Enums\Regalias;
use App\Repositories\FileRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Helpers\Enums\TeacherPositions;
use App\Models\EducationLevel;
use App\Models\ForeignTeacher;
use App\Models\Regalia;
use App\Models\Role;
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
            5,
            4,
        ];

        $highEducation = EducationLevel::where('name', EducationLevels::LEVEL_HIGHER->value)->first()->id;

        $teachers = [
            [
                'proof_document_link' => 'some_link',
                'dissertation_proof' => '14.08.2008г. на кафедре высшей математики Универсального института инновационных технологий города Москвы защитила диссертацию на соискание ученой степени кандидата на тему «Риски и пути минимизации в деятельности коммерческих банков» по специальности «Экономика и управление народным хозяйством» (08.00.05)',
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'professional_interests' => 'Разнообразный и богатый опыт укрепление и развитие структуры требуют от нас анализа модели развития. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.
                Не следует, однако забывать, что начало повседневной работы по формированию позиции требуют от нас анализа позиций, занимаемых участниками в отношении поставленных задач. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий позволяет оценить значение дальнейших направлений развития. Таким образом сложившаяся структура организации в значительной степени обуславливает создание новых предложений. Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности требуют определения и уточнения новых предложений.',
                'surname' => "Тягульская",
                'name' => "Людмила",
                'patronymic' => "Анатольевна",
                'teacher_position_id' => 3,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/tyagulska.png'),
                'additional_info' => [
                    'role' => array(DashboardRoles::ROLE_OWNER->value),
                    'regalias' => [
                        Regalia::where('name', Regalias::REGALIA_ECONOMY_CANDIDAT->value)->first()->id,
                        Regalia::where('name', Regalias::REGALIA_DEPARTMENT_OWNER->value)->first()->id,
                    ]
                ],
                'study_link' => 'https://vk.com/away.php?to=https%3A%2F%2Fus04web.zoom.us%2Fj%2F4059315500%3Fpwd%3DdmVIb1VROGtjaHAwMmFJNmRvT243QT09&cc_key=',
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
                'teacher_position_id' => 3,
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
                'teacher_position_id' => 3,
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
                'teacher_position_id' => 3,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/glazov.png'),
                'study_link' => 'https://vk.com/away.php?to=https%3A%2F%2Fus04web.zoom.us%2Fj%2F4483517670%3Fpwd%3DMVhLaitCRGoreURNY25aYTd5NFpjZz09',
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
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 3,
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
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 1,
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
                'teacher_position_id' => 1,
                'avatar_path' => $this->fileRepository->getFileLink('teachers/nagaevskaya.png'),
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],
            //Борсуковского Сергея Васильевича в расписании нет
            [
                'education' => 'ПГКУ им. Шевченко в 1994г.,
                математика и физика, учитель математики и физики',
                'surname' => "Борсуковский", 
                'name' => "Сергей",
                'patronymic' => "Васильевич",
                'teacher_position_id' => 2,
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
                'teacher_position_id' => 4,
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
                'teacher_position_id' => 5,
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
                'teacher_position_id' => 1,
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
                'surname' => "Анненков",
                'name' => "Андрей",
                'patronymic' => "Александрович",
                'teacher_position_id' => 1,
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
                'surname' => "Коцюржинский",
                'name' => "Леонард",
                'patronymic' => "Генадьевич",
                'teacher_position_id' => 1,
                'avatar_path' => '',
                'publications_count' => 5432,
                'projects_count' => 876,
                'conferences_count' => 432,
                'diploma_projects_count' => 345,
                'education_level_id' => $highEducation
            ],





            // преподаватели с других кафедр
            [
                'surname' => "Никитина",
                'name' => "Татьяна",
                'patronymic' => "Ивановна",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Новицкая",
                'name' => "Наталья",
                'patronymic' => "Павловна",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'https://vk.com/away.php?to=https%3A%2F%2Fus04web.zoom.us%2Fj%2F74136518851%3Fpwd%3DYmZzNk9TU0hjREcxMkNVUzNhNjdiQT09&cc_key=',
            ],
            [
                'surname' => "Борисюк",
                'name' => "Валерий",
                'patronymic' => "Николаевич",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Егорова",
                'name' => "Виктория",
                'patronymic' => "Григорьевна",
                'teacher_position_id' => 3,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Саввина",
                'name' => "М",
                'patronymic' => "Г",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Павлинова",
                'name' => "Ирина",
                'patronymic' => "Васильева",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Задобривская",
                'name' => " Оксана",
                'patronymic' => " Федоровна",
                'teacher_position_id' => 3,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Саввина",
                'name' => "Людмила",
                'patronymic' => "Ивановна",
                'teacher_position_id' => 3,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Шумилова",
                'name' => "Инга",
                'patronymic' => "Федоровна",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            [
                'surname' => "Мосежный",
                'name' => "Владимир",
                'patronymic' => "Иванович",
                'teacher_position_id' => 2,
                'foreign' => true,
                'study_link' => 'study_link_here',
            ],
            ];

            foreach($teachers as $teacher) {
                if(isset($teacher['foreign']) && $teacher['foreign'] === true) { // если это преподаватель с другой кафедры, заносим в отдельную таблицу
                    $foreignTeacher = new ForeignTeacher;
                    $foreignTeacher->name = $teacher['name'];
                    $foreignTeacher->surname = $teacher['surname'];
                    $foreignTeacher->patronymic = $teacher['patronymic'];
                    $foreignTeacher->teacher_position_id = $teacher['teacher_position_id'];
                    $foreignTeacher->slug = Str::slug($teacher['surname']. ' '.$teacher['name'].' '.$teacher['patronymic']);
                    if(isset(($teacher['study_link']))) {
                        $foreignTeacher->study_link = $teacher['study_link'];
                    }
                    $foreignTeacher->save();
                } else { // в ином случае создаем пользователя под каждого преподавателя
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

                    $this->userRepository->setRole($newUser->id, Role::where('name', DashboardRoles::ROLE_TEACHER->value)->first()->id);

                    $roleId = $this->teacherRepository->switchRoles($teacher['teacher_position_id']);

                    if(in_array($teacher['teacher_position_id'], $additionalTeachersRoles)) {
                        // если преподаватель имеет дополнительный функционал(инженер, лаборант), привязываем еще 1 роль
                        $this->userRepository->setRole($newUser->id, $roleId);
                    }

                    $newTeacher = new Teacher;
                    $newTeacher->user()->associate($newUser->id);
                    $newTeacher->avatar_path = $teacher['avatar_path'];
                    $newTeacher->education_level_id = $teacher['education_level_id'];
                    $newTeacher->publications_count = $teacher['publications_count'];
                    $newTeacher->projects_count = $teacher['projects_count'];
                    $newTeacher->conferences_count = $teacher['conferences_count'];
                    $newTeacher->diploma_projects_count = $teacher['diploma_projects_count'];
                    $newTeacher->slug = Str::slug($teacher['surname']. ' '.$teacher['name'].' '.$teacher['patronymic']);

                    if(isset($teacher['teacher_position_id'])) $newTeacher->teacher_position_id = $teacher['teacher_position_id'];
                    if(isset($teacher['proof_document_link'])) $newTeacher->proof_document_link = $teacher['proof_document_link'];
                    if(isset($teacher['dissertation_proof'])) $newTeacher->dissertation_proof = $teacher['dissertation_proof'];
                    if(isset($teacher['professional_interests'])) $newTeacher->professional_interests = $teacher['professional_interests'];
                    if(isset($teacher['study_link'])) $newTeacher->study_link = $teacher['study_link'];
                    $newTeacher->save();

                    if(isset($teacher['additional_info']['regalias'])) {
                        foreach($teacher['additional_info']['regalias'] as $regalia) {
                            $newTeacher->regalias()->attach($regalia);
                        }
                    }
                }
            }
        }
    }
