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
            directions: []
        }
    },
    methods: {
        newModal() {
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getDirection()
        },
        async getDirection() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'direction')
                .then(({data}) => this.directions = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить направления обучения'))
        }
    },
    async created() {
        await this.getDirection()
    }
}
</script>

<style lang="scss" scoped>

</style>
