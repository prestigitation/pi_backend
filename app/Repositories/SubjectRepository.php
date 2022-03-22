<?php

namespace App\Repositories;

use App\Models\ForeignTeacher;
use App\Models\Subject;
use App\Models\Teacher;
use Prettus\Repository\Eloquent\BaseRepository;

class SubjectRepository extends BaseRepository {
    public function model() {
        return Subject::class;
    }

    public function loadAll()
    {
        return Subject::query();
    }

    public function getPaginated() {
        return $this->loadAll()->with(['teachers', 'foreignTeachers'])->paginate(10);
    }

    public function getAll() {
        return $this->loadAll()->get();
    }

    private function attachSubject(mixed $data, $subject, string $entity = 'teachers') {
        foreach($data[$entity] as $model) {
            if($entity === 'teachers') {
                $subject->teachers()->attach($model['id']);
            } else if($entity === 'foreign_teachers') {
                $subject->foreignTeachers()->attach($model['id']);
            }
        }
    }

    public function create(array $data) {
        $subject = parent::create($data);
        $subject->save();
        if(isset($data['foreign_teachers'])) {
            $this->attachSubject($data, $subject, 'foreign_teachers');
        }

        if(isset($data['teachers'])) {
            $this->attachSubject($data, $subject);
        }
    }

    public function updateCustom(array $data, int $id) {
        $subject = Subject::find($id);

        if(isset($data['foreign_teachers'])) {
            $subject->foreignTeachers()->detach();
            $this->attachSubject($data, $subject, 'foreign_teachers');
        }

        if(isset($data['teachers'])) {
            $subject->teachers()->detach();
            $this->attachSubject($data, $subject);
        }

    }
}
