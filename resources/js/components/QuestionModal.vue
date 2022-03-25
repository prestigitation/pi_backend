<template>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление вопроса</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование вопроса</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="editmode ? updateQuestion() : createQuestion()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Вопрос</label>
                            <input v-model="form.question" type="text" name="question" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ответ</label>
                            <wysiwyg v-model="form.answer" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Изменить</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>

<script>
import { notificationMixin } from '../mixins/notificationMixin.js'
export default {
    mixins: [notificationMixin],
    name: "question-modal",
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => { }
        },
        questionId: {
            type: Number,
        },
    },
    methods: {
        async updateQuestion() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `questions/${this.questionId}`, this.form).then(() => {
                this.showSuccessMessage("Вопрос был успешно изменен");
            }).catch(() => {
                this.showFailMessage("Не удалось изменить данные о вопросе");
            }).finally(async () => {
                this.$emit("close_question_modal");
            });
        },
        async createQuestion() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + "questions", this.form)
                .then(() => {
                this.showSuccessMessage("Вопрос был успешно добавлен!");
            }).catch(() => this.showFailMessage("Не удалось добавить вопрос"))
                .finally(() => { this.$emit("close_question_modal") });
        },
    },
}
</script>


