<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список аудиторий
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
                            <th class="align-middle text-center">Вместимость</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="audience in audiences" :key="audience.id">
                        <td>
                            {{audience.id}}
                        </td>
                        <td>
                            {{audience.name}}
                        </td>
                        <td>
                            {{audience.capacity}}
                        </td>
                        <td>
                            <a href="#" @click="editAudience(audience)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteAudience(audience.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer" v-if="audiences && audiences.length">
                <pagination :data="audiences" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <audience-modal
            @close_direction_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form.sync="form"
            :audienceId.sync="audience_id"
        />
    </div>
    </div>
</section>
</template>

<script>
import AudienceModal from './AudienceModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'groups',
    mixins: [notificationMixin],
    components: {
    AudienceModal,
},
    data() {
        return {
            audiences: [],
            audience_id: undefined,
            editmode: false,
            form: new Form({
                name: '',
                capacity: ''
            }),
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getAudiences()
        },
        editAudience(audience) {
            this.audience_id = audience.id
            this.editmode = true
            this.form.fill(audience)
            $('#addNew').modal('show');
        },
        async deleteAudience(audienceId) {
            Swal.fire({
                        title: 'Удаление группы',
                        text: "Вы действительно хотите удалить информацию о данной аудитории?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`audiences/${audienceId}`).then(async ()=>{
                                        this.showSuccessMessage('Аудитория была успешно удалена!')
                                        await this.getAudiences();
                                    })
                            }
                        })
        },
        async getAudiences() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'audiences/all')
                .then(({data}) => this.audiences = data)
                .catch(() => this.showFailMessage('Не удалось загрузить данные об аудитории'))
        }
    },
    async created() {
        await this.getAudiences()
    }
}
</script>
