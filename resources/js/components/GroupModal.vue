<template>
<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление группы</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о группе</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateGroup() : createGroup()">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Название группы</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <user-roles
                            :input_cut="false"
                            @setCurrentUser="setCurator"
                        >
                        <template #title>
                            Выбор куратора
                        </template>
                        <template #table_actions_content>
                            <span class="btn btn-primary">Выбрать куратором</span>
                        </template>
                        </user-roles>

                        <user-roles
                            :input_cut="false"
                            @setCurrentUser="setHeadman"
                        >
                        <template #title>
                            Выбор старосты
                        </template>
                        <template #table_actions_content>
                            <span class="btn btn-primary">Выбрать старостой</span>
                        </template>
                        </user-roles>


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
export default {
    name: 'group-modal',
    components: {
        UserRoles
    },
    data() {
        return {

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
        groupId: {
            type: Number,
        }
    },
    methods: {
        async updateGroup() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `group/${this.groupId}`, this.form).then(() => {
                this.showSuccessMessage('Групппа была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о группе')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createGroup() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'group', this.form)
                .then(() => {
                    this.showSuccessMessage('Группа была успешно добавлена!')
                    this.$emit('close_direction_modal')
                }).catch(() => this.showFailMessage('Не удалось добавить группу'))
                .finally(() =>  this.$emit('close_direction_modal'))
        },
        setCurator(user) {
            this.$emit('setCurator', user)
        },
        setHeadman(user) {
            this.$emit('setHeadman', user)
        }
    },
    mixins: [notificationMixin]
}
</script>
