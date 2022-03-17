<?php

namespace App\Repositories;

use App\Models\Pair;
use Stevebauman\Purify\Facades\Purify;

class PairRepository {
    private $purifier;
    public function __construct(Purify $purifier) {
        $this->purifier = $purifier;
    }

    public function loadAll() {
        return Pair::query();
    }

    public function getAll()
    {
        return $this->loadAll()->get();
    }

    public function getPaginated() {
        return $this->loadAll()->paginate(10);
    }

    public function addPairInfo(Pair $pair, array $data) {
        $pair->subject_id = $data['subject_id'];
        $pair->additional_info =  $this->purifier::clean($data['additional_info']);
        $pair->teacher_id = $data['teacher_id'];
        //TODO: привязка предмета к преподавателю, при помощи полиморфной связи
        $pair->audience = $data['audience'];
        $pair->type_id = $data['type_id'] ?? null;
    }

    public function create(array $data)
    {
        $pair = new Pair;
        $this->addPairInfo($pair, $data);
        $pair->save();
    }

    public function update(array $data, int $id)
    {
        $pair = Pair::find($id);
        $this->addPairInfo($pair, $data);
        $pair->save();
    }
}
