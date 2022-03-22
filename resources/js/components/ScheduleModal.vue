<template>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление записи в расписание</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о расписании</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="editmode ? updateSchedule() : createSchedule()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Группа</label>
                            <select name="type" v-model="form.group_id" id="type" class="form-control">
                                <option v-for="group in groups" :key="group.id" :value="group.id">
                                    {{group.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>День недели</label>
                            <select name="type" v-model="form.day_id" id="type" class="form-control">
                                <option v-for="day in days" :key="day.id" :value="day.id">
                                    {{day.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Время проведения</label>
                            <select name="type" v-model="form.pair_number_id" id="type" class="form-control">
                                <option v-for="number in pairNumbers" :key="number.id" :value="number.id">
                                    {{number.number}} пара - {{number.start}} - {{number.end}}
                                </option>
                            </select>
                        </div>

                        <span class="form-group">
                            <span class="btn btn-primary" @click.prevent="addPairToSchedule">
                                Прикрепить пару +
                            </span>
                            <div v-for="pair, index in form.pairs" :key="index">
                                <hr style="border: 5px solid black;">
                                <div class="btn btn-danger d-block w-50 mx-auto my-2" @click.prevent="deleteScheduleEntry(index)">
                                    Удалить эту запись
                                </div>
                                <label>Выберите преподавателя</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="form.pairs[index].is_foreign" id="checkbox">
                                    <label class="form-check-label" for="checkbox">
                                        Преподаватели с других кафедр
                                    </label>
                                </div>
                                <span v-show="form.pairs[index].is_foreign">
                                    <select name="teacher" v-model="form.pairs[index].teacher_id" id="teacher" class="form-control">
                                        <option v-for="teacher in foreignTeachers" :key="teacher.id" :value="teacher.id">
                                            <user-name-data :user="teacher" />
                                        </option>
                                    </select>
                                </span>
                                <span v-show="!form.pairs[index].is_foreign">
                                    <select name="teacher" v-model="form.pairs[index].teacher_id" id="teacher" class="form-control">
                                        <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                            <user-name-data :user="teacher.user ? teacher.user : teacher" />
                                        </option>
                                    </select>
                                </span>

                                <label>Выберите очередность проведения</label>
                                <select name="type" v-model="form.pairs[index].type_id" id="type" class="form-control">
                                    <option v-for="type in types" :key="type.id" :value="type.id">
                                        {{type.name}}
                                    </option>
                                </select>


                                <label>Выберите аудиторию проведения пары</label>
                                <select name="audience" v-model="form.pairs[index].audience_id" id="audience" class="form-control">
                                    <option v-for="audience in audiences" :key="audience.id" :value="audience.id">
                                        {{audience.name}} (Вместимость: {{audience.capacity}} чел.)
                                    </option>
                                </select>
                                <label>Выберите предмет</label>
                                <select name="subject" v-model="form.pairs[index].subject_id" id="subject" class="form-control">
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                        {{subject.name}}
                                    </option>
                                </select>

                                <div class="form-group">
                                    <label>Выберите формат обучения(опционально)</label>
                                    <select name="type" v-model="form.pairs[index].study_process_id" id="type" class="form-control">
                                        <option v-for="process in processes" :key="process.id" :value="process.id">
                                            {{process.name}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Выберите формат проведения пары(опционально)</label>
                                    <select name="type" v-model="form.pairs[index].format_id" id="type" class="form-control">
                                        <option v-for="format in formats" :key="format.id" :value="format.id">
                                            {{format.name}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Добавьте дополнительную информацию(опционально)</label>
                                    <input v-model="form.pairs[index].additional_info" type="text" name="additional_info" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Добавьте информацию о дате начала пар(опционально)</label>
                                    <input v-model="form.pairs[index].start_date_info" type="text" name="additional_info" class="form-control">
                                </div>
                                <hr style="border: 3px solid black;">
                            </div>
                        </span>

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
import PairPresenter from './layout/PairPresenter.vue'
import UserNameData from './layout/UserNameData.vue'
export default {
    name: "group-modal",
    data() {
        return {
            days: [],
            pairNumbers: [],
            groups: [],
            pairs: [],
            selectedPair: 1,
            teachers: [],
            foreignTeachers: [],
            types: [],
            audiences: [],
            subjects: [],
            formats: [],
            processes: [],
            is_foreign: false,
        };
    },
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => { }
        },
        scheduleId: {
            type: Number,
        },
    },
    methods: {
        async updateSchedule() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `schedules/${this.scheduleId}`, this.form).then(() => {
                this.showSuccessMessage("Групппа была успешно изменена");
            }).catch(() => {
                this.showFailMessage("Не удалось изменить данные о группе");
            }).finally(async () => {
                this.$emit("close_schedule_data_modal");
            });
        },
        async createSchedule() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + "schedules", this.form)
                .then(() => {
                this.showSuccessMessage("Запись была успешно добавлена!");
            }).catch(() => this.showFailMessage("Не удалось добавить запись в расписании"))
                .finally(() => { this.$emit("close_direction_modal") });
        },
        async getGroups() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "groups/all")
                .then(({ data }) => this.groups = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить группы"));
        },
        async getTeachers() {
            await axios.get(process.env.MIX_API_PATH + "teachers")
                .then(({ data }) => this.teachers = data)
                .catch(() => this.showFailMessage("Не удалось загрузить преподавателей"));
        },
        async getForeignTeachers() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "foreign_teachers/all")
                .then(({ data }) => this.foreignTeachers = data)
                .catch(() => this.showFailMessage("Не удалось загрузить преподавателей с других кафедр"));
        },
        async getAudiences() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "audiences/all")
                .then(({ data }) => this.audiences = data)
                .catch(() => this.showFailMessage("Не удалось загрузить информацию об аудиториях"));
        },
        async getSubjects() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "subjects/all")
                .then(({ data }) => this.subjects = data)
                .catch(() => this.showFailMessage("Не удалось загрузить информацию об предметах"));
        },
        async getTypes() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "types/all")
                .then(({ data }) => this.types = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить очередность недель"));
        },
        async getDays() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "days")
                .then(({ data }) => this.days = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о времени обучения"));
        },
        async getPairNumbers() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "pair_numbers")
                .then(({ data }) => this.pairNumbers = data.data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о расписании для пар"));
        },
        async getFormats() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "pair_formats/all")
                .then(({ data }) => this.formats = data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о форматах работы на паре"));
        },
        async getStudyProcesses() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "study_processes/all")
                .then(({ data }) => this.processes = data)
                .catch(() => this.showFailMessage("Не удалось загрузить данные о проведении пар"));
        },
        addPairToSchedule() {
            this.$emit('add_pair_to_schedule', {
                type_id: '',
                subject_id: '',
                teacher_id: '',
                audience_id: '',
                additional_info: '',
                start_date_info: '',
                format_id: '',
                study_process_id: '',
                is_foreign: this.is_foreign
            })
        },
        deleteScheduleEntry(index) {
            this.$emit('delete_schedule_entry', index)
        },
        findCurrentPair(id) {
            return this.pairs.filter(pair => pair.id === id)[0]
        },
        addPair() {
            this.$emit("add_pair", this.findCurrentPair(this.selectedPair));
        },
        deletePair(index) {
            this.$emit("delete_pair", index);
        }
    },
    async created() {
        await this.getGroups()
        await this.getDays()
        await this.getPairNumbers()
        await this.getTeachers()
        await this.getForeignTeachers()
        await this.getTypes()
        await this.getAudiences()
        await this.getSubjects()
        await this.getFormats()
        await this.getStudyProcesses()
    },
    mixins: [notificationMixin],
    components: { PairPresenter, UserNameData }
}
</script>

<style lang="scss" scoped>
.pair {
    &__selector {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    &__wrapper {
        background: lightgray;
    }
    &__button:hover {
        cursor: pointer;
    }
}

</style>
