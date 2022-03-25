<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\QA\StoreQuestionRequest;
use App\Http\Requests\QA\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Repositories\QARepository;

class QAController extends BaseController {
    private $QARepository;
    public function __construct(QARepository $QARepository) {
        $this->QARepository = $QARepository;
        $this->middleware('can:accessQA');
    }

    public function getAll() {
        return new QuestionResource(Question::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        try {
            $this->QARepository->create($request->validated());
            return $this->sendResponse(null, 'Вопрос был успешно добавлен!');
        } catch (\Exception $e) {
            $this->sendError('Не удалось отправить вопрос');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        //TODO: ?new event -> send email
        try {
            $this->QARepository->updateCustom($request->validated(), $id);
            return $this->sendResponse(null, 'Вопрос был успешно изменен!');
        } catch (\Exception $e) {
            $this->sendError('Не удалось изменить содержание вопросa');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->QARepository->delete($id);
            return $this->sendResponse(null, 'Вопрос был успешно удален!');
        } catch (\Exception $e) {
            $this->sendError('Не удалось удалить вопрос');
        }
    }
}
