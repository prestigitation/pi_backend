<?php
namespace App\Repositories;

use App\Models\Question;
use Prettus\Repository\Eloquent\BaseRepository;
use Stevebauman\Purify\Purify;

class QARepository extends BaseRepository {
    private $purifier;
    public function __construct(Purify $purifier) {
        $this->purifier = $purifier;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Question::class;
    }

    function updateCustom(array $data, int $questionId) {
        $question = Question::find($questionId);

        $question->update($data);
    }
}
