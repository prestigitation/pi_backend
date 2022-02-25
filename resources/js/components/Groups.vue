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
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="group in groups" :key="group.id">
                        <td>
                            {{group}}
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
            id="addNew"
            :editmode="editmode"
            :form="form"
            :groupsId="groupsId"
        />
    </div>
    </div>
</section>
</template>

<script>
import GroupModal from './GroupModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'groups',
    mixins: [notificationMixin],
    components: {
        GroupModal
    },
    data() {
        return {
            groups: [],
            groupId: 1,
            editmode: false,
            form: new Form({
                name: '',
                curator_id: 1,
                headman_id: 1,
                direction_id: 1,
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
                                    this.form.delete(`group/${groupId}`).then(async ()=>{
                                        this.showSuccessMessage('Группа была успешно удалена!')
                                        await this.getGroups();
                                    })
                            }
                        })
        },
        async getGroups() {
            await axios.get(process.env.MIX_API_PATH + 'group')
                .then(({data}) => this.groups = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить группы'))
        }
    },
    async created() {
        await this.getGroups()
    }
}
</script>

<style lang="scss" scoped>

</style>
