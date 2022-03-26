<?php
namespace App\Repositories;

use App\Models\ForeignTeacher;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class ForeignTeacherRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ForeignTeacher::class;
    }


    public function create(array $data) {
        $foreignTeacher = new ForeignTeacher;
        $foreignTeacher->name = $data['name'];
        $foreignTeacher->surname = $data['surname'];
        $foreignTeacher->patronymic = $data['patronymic'];
        $foreignTeacher->slug = Str::slug($data['surname']. ' '.$data['name'].' '.$data['patronymic']);
        $foreignTeacher->position = $data['position'];
        if(isset($data['study_link'])) {
            $foreignTeacher->study_link = $data['study_link'];
        }
        $foreignTeacher->save();
    }
}
