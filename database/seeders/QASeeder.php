<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'nsp' => 'dummy',
                'email' => 'dummy@email.com',
                'question' => 'Какие документы необходимо предоставить при поступлении в 2021 году?'
            ],
            [
                'nsp' => 'dummy',
                'email' => 'dummy@email.com',
                'question' => 'Предоставляются ли скидки по оплате за обучение?'
            ],
            [
                'nsp' => 'dummy',
                'email' => 'dummy@email.com',
                'question' => 'Как поступить на платное обучение?',
                'answer' => 'Для поступления на платную основу необходимо заключить Договор об оказании платных образовательных услуг. Бланк договора подписывается поступающим и заказчиком обучения. Заказчиком обучения является тот, с чьего счета будет произведена оплата по договору. Если на момент подписания договора поступающему не исполнилось 18 лет, договор подписывается поступающим, его родителем и заказчиком обучения. Каждая страница договора должна быть завизирована поступающим и заказчиком обучения.
                Университет проверяет договор и подписывает со своей стороны. После оплаты указанной в договоре суммы денежных средств поступающий включается в приказ о зачислении.'
            ],
            [
                'nsp' => 'dummy',
                'email' => 'dummy@email.com',
                'question' => 'Какие минимальные баллы при поступлении?'
            ],
            [
                'nsp' => 'dummy',
                'email' => 'dummy@email.com',
                'question' => 'Учитывается ли средний балл диплома бакалавра при поступлении в магистратуру при ранжировании поступающих, при условии, что диплом бакалавра не по специальности?'
            ]
        ];

        foreach($questions as $question) {
            $newQuestion = new Question;
            $newQuestion->nsp = $question['nsp'];
            $newQuestion->email = $question['email'];
            $newQuestion->question = $question['question'];
            if(isset($question['answer'])) {
                $newQuestion->answer = $question['answer'];
            }
            $newQuestion->save();
        }
    }
}
