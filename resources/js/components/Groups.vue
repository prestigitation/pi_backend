<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список групп
                        </slot>
                    </h3>

                <div class="card-tools">

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Наименование</th>
                            <th class="align-middle text-center">Куратор</th>
                            <th class="align-middle text-center">Староста</th>
                            <th class="align-middle text-center">Направление</th>
                            <th class="align-middle text-center">Время и тип обучения</th>
                            <th class="align-middle text-center">Обучается на данный момент</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="group in groups" :key="group.id">
                        <td>
                            {{group.id}}
                        </td>
                        <td>
                            {{group.name}}
                        </td>
                        <td>
                            <user-name-data :user="group.curator" />
                        </td>
                        <td>
                            <user-name-data :user="group.headman" />
                        </td>
                        <td>
                            {{group.direction.code}} - {{group.direction.profile.name}}, {{group.direction.speciality.name}} - {{group.direction.study_form.name}}
                        </td>
                        <td>
                            <span>{{group.study_variant.years}}г. </span>
                            <span v-if="group.study_variant.months">{{group.study_variant.months}}мес.</span>
                            <span>{{group.study_variant.time_form.name}}</span>
                        </td>
                        <td>
                            {{group.is_active ? 'Да' : 'Нет'}}
                        </td>
                        <td>
                            <a href="#" @click="editGroup(group)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteGroup(group.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer" v-if="groups && groups.length">
                <pagination :data="groups" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <group-modal
            @close_direction_modal="closeModal"
            @set_headman="setHeadman"
            @set_curator="setCurator"
            id="addNew"
            :editmode="editmode"
            :form="form"
            :groupId="groupsId"
            :directions="directions"
        />
    </div>
    </div>
</section>
</template>

<script>
import GroupModal from './GroupModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
import UserNameData from './layout/UserNameData.vue'
export default {
    name: 'groups',
    mixins: [notificationMixin],
    components: {
    GroupModal,
    UserNameData
},
    data() {
        return {
            groups: [],
            directions: [],
            groupId: 1,
            editmode: false,
            form: new Form({
                name: '',
                curator_id: null,
                headman_id: null,
                direction_id: 1,
                study_variant_id: 0,
                is_active: false,
            }),
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.groupId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getGroups()
        },
        editGroup(group) {
            this.groupsId = group.id
            this.editmode = true
            this.form.fill(group)
            $('#addNew').modal('show');
        },
        setHeadman(headman) {
            this.form.headman_id = headman?.id
        },
        setCurator(curator) {
            this.form.curator_id = curator?.id
        },
        async deleteGroup(groupId) {
            Swal.fire({
                        title: 'Удаление группы',
                        text: "Вы действительно хотите удалить данную группу?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`groups/${groupId}`).then(async ()=>{
                                        this.showSuccessMessage('Группа была успешно удалена!')
                                        await this.getGroups();
                                    })
                            }
                        })
        },
        async getGroups() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'groups')
                .then(({data}) => this.groups = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить группы'))
        },
        async getDirections() {
            await axios.get(process.env.MIX_API_PATH + 'directions')
                .then(({data}) => this.directions = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить направления'))
        }
    },
    async created() {
        await this.getGroups()
        await this.getDirections()
    }
}
</script>
