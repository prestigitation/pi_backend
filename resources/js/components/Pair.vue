<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список пар
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
                            <th class="align-middle text-center">Предмет</th>
                            <th class="align-middle text-center">Преподаватель</th>
                            <th class="align-middle text-center">Аудитория</th>
                            <th class="align-middle text-center">Формат проведения</th>
                            <th class="align-middle text-center">Доп.информация</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="pair_data in pairs" :key="pair_data.id">
                        <td>
                            {{pair_data.id}}
                        </td>
                        <td>
                            {{pair_data.subject.name}}
                        </td>
                        <td>
                            <user-name-data :user="pair_data.teacher.user" />
                        </td>
                        <td>
                            {{pair_data.audience}}
                        </td>
                        <td>{{pair_data.type}}</td>
                        <td>{{pair_data.additional_info ? pair_data.additional_info : 'Нет информации'}}</td>
                        <td>
                            <a href="#" @click="editPair(pair_data)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deletePair(pair_data.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer" v-if="pairs.length">
                <pagination :data="pairs" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <pair-modal
            @close_direction_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form="form"
            :pairId="pairId"
        />
    </div>
    </div>
</section>
</template>

<script>
import PairModal from './PairModal.vue'
import UserNameData from './layout/UserNameData.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'pair',
    mixins: [notificationMixin],
    components: {
        PairModal,
        UserNameData
    },
    data() {
        return {
            pairs: [],
            pairId: 1,
            editmode: false,
            form: new Form({
                teacher_id: 1,
                subject_id: 1,
                audience: '',
                type: '',
                additional_info: ''
            }),
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.pairId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getPairs()
        },
        editPair(pair) {
            this.pairId = pair.id
            this.editmode = true
            this.form.fill(pair)
            $('#addNew').modal('show');
        },
        async deletePair(pairId) {
            Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить информацию о паре?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`pair/${pairId}`).then(async ()=>{
                                        this.showSuccessMessage('Информация о паре была успешно удалена!')
                                        await this.getPairs();
                                    })
                            }
                        })
        },
        async getPairs() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'pair')
                .then(({data}) => this.pairs = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить информацию о парах'))
        }
    },
    async created() {
        await this.getPairs()
    }
}
</script>

