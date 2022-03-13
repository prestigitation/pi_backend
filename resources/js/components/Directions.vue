<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список направлений
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
                            <th class="align-middle text-center">Код</th>
                            <th class="align-middle text-center">Профиль</th>
                            <th class="align-middle text-center">Квалификация</th>
                            <th class="align-middle text-center">Время обучения</th>
                            <th class="align-middle text-center">Форма обучения</th>
                            <th class="align-middle text-center">Форма оплаты</th>
                            <th class="align-middle text-center">Cоздан</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="direction in directions" :key="direction.id">
                        <td>
                            <span v-if="direction.id">
                                {{direction.id}}
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.code">
                                {{direction.code}}
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.profile.name">
                                {{direction.profile.name}}
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.speciality.name">
                                {{direction.speciality.name}}
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.study_variants.length">
                                <span v-for="variant,index in direction.study_variants" :key="variant.id">
                                    <span v-if="variant.years">{{variant.years}} г.</span>
                                    <span v-if="variant.months">{{variant.months}} мес.</span>
                                    <span v-if="variant.time_form.name">{{variant.time_form.name}}</span>
                                    <span v-if="index !== direction.study_variants.length - 1">{{ ', ' }}</span>
                                </span>
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.study_form.name">
                                {{direction.study_form.name}}
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.payment_forms.length">
                                <span v-for="payment, index in direction.payment_forms" :key="payment.id">
                                    <span>{{payment.name}}</span>
                                    <span v-if="index !== direction.payment_forms.length - 1">{{', '}}</span>
                                </span>
                            </span>
                        </td>
                        <td>
                            <span v-if="direction.created_at">
                                {{direction.created_at}}
                            </span>
                        </td>
                        <td>
                            <a href="#" @click="editDirection(direction)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteDirection(direction.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" v-if="directions.length">
                <pagination :data="directions" @pagination-change-page="getResults"></pagination>
            </div>
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <direction-modal
            @close_direction_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form="form"
            :directionId="directionId"
        />
    </div>
    </div>
</section>
</template>

<script>
import DirectionModal from './DirectionModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'directions',
    mixins: [notificationMixin],
    components: {
        DirectionModal
    },
    data() {
        return {
            directions: [],
            editmode: false,
            form: new Form({
                code: '',

                study_form: 0,
                speciality: 0,
                profile: 0,

                study_variants: [{}],
                payment_forms: [{}]
            }),
            directionId: null
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.directionId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getDirections()
        },
        editDirection(direction) {
            this.directionId = direction.id
            this.editmode = true
            this.form.fill(direction)
            $('#addNew').modal('show');
        },
        async deleteDirection(directionId) {
            Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить данное направление?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`directions/${directionId}`).then(async ()=>{
                                        this.showSuccessMessage('Направление было успешно удалено!')
                                        await this.getDirections();
                                    })
                            }
                        })
        },
        async getDirections() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'directions')
                .then(({data}) => this.directions = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить направления обучения'))
        }
    },
    async created() {
        await this.getDirections()
    }
}
</script>
