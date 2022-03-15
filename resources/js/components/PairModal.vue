<template>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление пары</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о новости</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updatePair() : createPair()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Предмет</label>
                            <select name="type" v-model="form.subject_id" id="type" class="form-control">
                                <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                    {{subject.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Преподаватель</label>
                            <select name="type" v-model="form.teacher_id" id="type" class="form-control">
                                <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                    <user-name-data :user="teacher.user" />
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Аудитория</label>
                            <input v-model="form.audience" type="text" name="audience" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Доп.информация(опционально)</label>
                            <wysiwyg v-model="form.additional_info" />
                        </div>

                        <div class="form-check" v-for="type in types" :key="type.id">
                            <input class="form-check-input" :value="type.id" type="radio" v-model="form.type_id" name="flexRadioDefault" :id='`flexRadioDefault${type.id}`'>
                            <label class="form-check-label" :for='`flexRadioDefault${type.id}`'>
                                {{type.name}}
                            </label>
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
import {notificationMixin} from '../mixins/notificationMixin'
import UserNameData from './layout/UserNameData.vue'
export default {
    name: 'user-modal',
    components: {
        UserNameData
    },
    data() {
        return {
            pairNumbers: [],
            days: [],
            teachers: [],
            subjects: [],
            types: []
        }
    },
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => {}
        },
        pairId: {
            type: Number,
        }
    },
    async mounted() {
        await this.getPairNumbers()
        await this.getDays()
        await this.getTeachers()
        await this.getSubjects()
        await this.getTypes()
    },
    methods: {
        async getSubjects() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'subjects/all')
                .then(({data}) => this.subjects = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить информацию о предметах'))
        },
        async getTypes() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'types/all')
                .then(({data}) => this.types = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить типы проведения пар'))
        },
        async updatePair() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `pairs/${this.pairId}`, this.form).then(() => {
                this.showSuccessMessage('Пара была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о паре')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createPair() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'pairs', this.form)
                .then(() => {
                    this.showSuccessMessage('Пара была успешно добавлена!')
                }).catch(() => this.showFailMessage('Не удалось добавить новость'))
                .finally(() =>  this.$emit('close_direction_modal'))
        },
        async getDays() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'days')
                .then(({data}) => this.days = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить данные о времени обучения'))
        },
        async getPairNumbers() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'pair_numbers')
                .then(({data}) => this.pairNumbers = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить данные о расписании для пар'))
        },
        async getTeachers() {
            await axios.get(process.env.MIX_API_PATH + 'teachers')
                .then(({data}) => this.teachers = data)
                .catch(() => this.showFailMessage('Не удалось загрузить преподавателей'))
        }
    },
    mixins: [notificationMixin]
}
</script>
