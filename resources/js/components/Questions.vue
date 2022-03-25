<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список вопросов и ответов
                        </slot>
                    </h3>

                <div class="card-tools">

                <!--<button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button> -->
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Инициалы</th>
                            <th class="align-middle text-center">E-mail</th>
                            <th class="align-middle text-center">Вопрос</th>
                            <th class="align-middle text-center">Ответ</th>
                            <th class="align-middle text-center">Дата создания</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="question in questions" :key="question.id">
                        <td>
                            {{question.id}}
                        </td>
                        <td>
                            {{question.nsp}}
                        </td>
                        <td>
                            {{question.email}}
                        </td>
                        <td>
                            {{question.question}}
                        </td>
                        <td class="text-center">
                            <span v-if="question.answer">
                                {{ question.answer }}
                            </span>
                            <span v-else class="btn btn-success" @click="editQuestion(question)">
                                Ответить на вопрос
                            </span>
                        </td>
                        <td>
                            {{question.created_at}}
                        </td>
                        <td>
                            <a href="#" @click="editQuestion(question)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteQuestion(question.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" v-if="questions.length">
                <pagination :data="questions" @pagination-change-page="getResults"></pagination>
            </div>
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <question-modal
            @close_question_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form.sync="form"
            :questionId.sync="questionId"
        />
    </div>
    </div>
</section>
</template>

<script>
import QuestionModal from './QuestionModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'questions',
    mixins: [notificationMixin],
    components: {
        QuestionModal
    },
    data() {
        return {
            questions: [],
            editmode: false,
            form: new Form({
                question: '',
                answer: '',
                nsp: '',
                email: ''
            }),
            questionId: null
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.questionId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getQuestions()
        },
        editQuestion(question) {
            this.questionId = question.id
            this.editmode = true
            this.form.fill(question)
            $('#addNew').modal('show');
        },
        async deleteQuestion(questionId) {
            Swal.fire({
                        title: 'Удаление вопроса',
                        text: "Вы действительно хотите удалить данный вопрос?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                this.form.delete(`questions/${questionId}`).then(async ()=>{
                                    this.showSuccessMessage('Вопрос был успешно удален!')
                                    await this.getQuestions();
                                })
                            }
                        })
        },
        async getQuestions() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'questions/all')
                .then(({data}) => this.questions = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить вопросы'))
        }
    },
    async created() {
        await this.getQuestions()
    }
}
</script>
