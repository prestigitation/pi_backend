<template>
<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление аудитории</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о аудитории</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateAudience() : createAudience()">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Название</label>
                            <input v-model="form.name" type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Вместимость</label>
                            <input v-model="form.capacity" type="text" name="name" class="form-control">
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
import UserRoles from './UserRoles.vue'
import UserNameData from './layout/UserNameData.vue'
export default {
    name: 'group-modal',
    components: {
    UserRoles,
    UserNameData
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
        audienceId: {
            type: Number,
        },
    },
    methods: {
        async updateAudience() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `audiences/${this.audienceId}`, this.form).then(() => {
                this.showSuccessMessage('Аудитория была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о аудитории')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createAudience() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'audiences', this.form)
                .then(() => {
                    this.showSuccessMessage('Аудитория была успешно добавлена!')
                }).catch(() => this.showFailMessage('Не удалось добавить аудиторию'))
                .finally(() =>  this.$emit('close_direction_modal'))
        },
    },
    mixins: [notificationMixin]
}
</script>
