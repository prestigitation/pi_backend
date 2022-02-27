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
export default {
    name: 'group-modal',
    data() {
        return {
            days: [],
            pairNumbers: [],
            groups: []
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
        scheduleId: {
            type: Number,
        },
    },
    methods: {
        async updateGroup() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `schedule/${this.scheduleId}`, this.form).then(() => {
                this.showSuccessMessage('Групппа была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о группе')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createSchedule() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'schedule', this.form)
                .then(() => {
                    this.showSuccessMessage('Запись была успешно добавлена!')
                }).catch(() => this.showFailMessage('Не удалось добавить запись в расписании'))
                .finally(() =>  this.$emit('close_direction_modal'))
        },
        async getGroups() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'group/all')
                .then(({data}) => this.groups = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить группы'))
        },
        async getDays() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'day')
                .then(({data}) => this.days = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить данные о времени обучения'))
        },
        async getPairNumbers() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'pair_number')
                .then(({data}) => this.pairNumbers = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить данные о расписании для пар'))
        }
    },
    async created() {
        await this.getGroups()
        await this.getDays()
        await this.getPairNumbers()
    },
    mixins: [notificationMixin]
}
</script>
