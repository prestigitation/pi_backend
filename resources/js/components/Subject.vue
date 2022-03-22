<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список предметов
                        </slot>
                    </h3>

                <div class="card-tools">

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Наименование</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="subject in subjects" :key="subject.id">
                        <td>
                            {{subject.id}}
                        </td>
                        <td>
                            {{subject.name}}
                        </td>
                        <td>
                            <a href="#" @click="editSubject(subject)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteSubject(subject.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" v-if="subjects.length">
                <pagination :data="subjects" @pagination-change-page="getResults"></pagination>
            </div>
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <subject-modal
            @close_subject_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form.sync="form"
            :subjectId.sync="subjectId"
        />
    </div>
    </div>
</section>
</template>

<script>
import SubjectModal from './SubjectModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'subject',
    mixins: [notificationMixin],
    components: {
        SubjectModal
    },
    data() {
        return {
            subjects: [],
            editmode: false,
            form: new Form({
                name: '',
                teachers: [],
                foreign_teachers: []
            }),
            subjectId: null
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.subjectId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getSubjects()
        },
        editSubject(subject) {
            this.subjectId = subject.id
            this.editmode = true
            this.form.fill(subject)
            $('#addNew').modal('show');
        },
        async deleteSubject(subjectId) {
            Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить данный предмет?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`subjects/${subjectId}`).then(async ()=>{
                                        this.showSuccessMessage('Направление было успешно удалено!')
                                        await this.getDirections();
                                    })
                            }
                        })
        },
        async getSubjects() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'subjects')
                .then(({data}) => this.subjects = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить предметы'))
        }
    },
    async created() {
        await this.getSubjects()
    }
}
</script>
