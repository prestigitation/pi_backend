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
                            <input v-model="form.name" type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Направление</label>
                            <select name="type" v-model="form.direction_id" id="type" class="form-control">
                                <option v-for="direction in directions" :key="direction.id" :value="direction.id">
                                    {{direction.speciality.name}}, {{direction.profile.name}}, {{direction.study_form.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Варианты обучения</label>
                            <select name="type" v-model="form.study_variant_id" id="type" class="form-control">
                                <option v-for="variant in getStudyVariants(form.direction_id)" :key="variant.id" :value="variant.id">
                                    <span v-if="variant.years">{{variant.years}} г.</span>
                                    <span v-if="variant.months">{{variant.months}} мес.</span>
                                    <span v-if="variant.time_form.name">{{variant.time_form.name}}</span>
                                </option>
                            </select>
                        </div>

                        <div class="form-check">
                            <input v-model="form.is_active" class="form-check-input" type="checkbox" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Обучается на данный момент
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Выбор куратора</label>
                            <div v-if="!form.curator_id">
                                <user-roles
                                    :input_cut="false"
                                    @setCurrentUser="setCurator"
                                >
                                <span slot="title" />
                                <template #table_actions_content>
                                    <span class="btn btn-primary">Выбрать куратором</span>
                                </template>
                                </user-roles>
                            </div>
                            <div v-else>
                                <user-name-data :user="curator" />
                                <span @click.prevent="clearCurator">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM168 232C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H168z"/></svg>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Выбор старосты</label>
                            <div v-if="!form.headman_id">
                                <user-roles
                                    :input_cut="false"
                                    @setCurrentUser="setHeadman"
                                >
                                <span slot="title" />
                                <template #table_actions_content>
                                    <span class="btn btn-primary">Выбрать старостой</span>
                                </template>
                                </user-roles>
                            </div>
                            <div v-else>
                                <user-name-data :user="headman" />
                                <span @click.prevent="clearHeadman">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM168 232C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H168z"/></svg>
                                </span>
                            </div>
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
    data() {
        return {
            curator: undefined,
            headman: undefined,
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
        },
        directions: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        async updateGroup() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `groups/${this.groupId}`, this.form).then(() => {
                this.showSuccessMessage('Групппа была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о группе')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createGroup() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'groups', this.form)
                .then(() => {
                    this.showSuccessMessage('Группа была успешно добавлена!')
                }).catch(() => this.showFailMessage('Не удалось добавить группу'))
                .finally(() =>  this.$emit('close_direction_modal'))
        },
        getStudyVariants(directionId) {
            return this.directions.filter(direction => direction.id === directionId)[0].study_variants
        },
        setCurator(curator) {
            this.curator = curator
            this.$emit('set_curator', curator)
        },
        setHeadman(headman) {
            this.headman = headman
            this.$emit('set_headman', headman)
        },
        clearHeadman() {
            this.$emit('set_headman', null)
        },
        clearCurator() {
            this.$emit('set_curator', null)
        }
    },
    mixins: [notificationMixin]
}
</script>
