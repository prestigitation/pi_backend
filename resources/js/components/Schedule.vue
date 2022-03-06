<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Таблица расписания
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
                            <th class="align-middle text-center">Группа</th>
                            <th class="align-middle text-center">Номер пары</th>
                            <th class="align-middle text-center">День проведения</th>
                            <th class="align-middle text-center">Предмет(/-ы)</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="schedule_data in schedules" :key="schedule_data.id">
                        <td>
                            {{schedule_data.id}}
                        </td>
                        <td>
                            {{schedule_data.group.name}}
                        </td>
                        <td>
                            <pair-number-presenter :pairNumber="schedule_data.pair_number" />
                        </td>
                        <td>
                            {{schedule_data.day.name}}
                        </td>
                        <td>
                            <div v-for="pair in schedule_data.pairs">
                                <pair-presenter :pair="pair" />
                            </div>
                        </td>
                        <td>
                            <a href="#" @click="editSchedule(schedule_data)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteSchedule(schedule_data.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" v-if="schedules && schedules.length">
                <pagination :data="schedules" @pagination-change-page="getResults"></pagination>
            </div>
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <schedule-modal
            @close_schedule_data_modal="closeModal"
            @add_pair="addPair"
            @delete_pair="deletePair"
            id="addNew"
            :editmode="editmode"
            :form="form"
            :scheduleId="scheduleId"
        />
    </div>
    </div>
</section>
</template>

<script>
import ScheduleModal from './ScheduleModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
import PairNumberPresenter from './layout/PairNumberPresenter.vue'
import PairPresenter from './layout/PairPresenter.vue'
export default {
    name: 'schedule',
    mixins: [notificationMixin],
    components: {
    ScheduleModal,
    PairNumberPresenter,
    PairPresenter
},
    data() {
        return {
            schedules: [],
            editmode: false,
            form: new Form({
                group_id: 1,
                day_id: 1,
                pair_number_id: 1,
                pairs: []
            }),
            scheduleId: null
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.scheduleId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getSchedule()
        },
        addPair(pair) {
            this.form.pairs.push(pair)
        },
        deletePair(index) {
            this.form.pairs.splice(index, 1)
        },
        editSchedule(schedule) {
            this.scheduleId = schedule.id
            this.editmode = true
            this.form.fill(schedule)
            $('#addNew').modal('show');
        },
        async deleteSchedule(scheduleId) {
            Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить этот пункт в расписании?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`schedule/${scheduleId}`).then(async ()=>{
                                        this.showSuccessMessage('Часть расписания была успешно удалена!')
                                        await this.getSchedule();
                                    })
                            }
                        })
        },
        async getSchedule() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'schedule')
                .then(({data}) => this.schedules = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить направления обучения'))
        },
    },
    async created() {
        await this.getSchedule()
    }
}
</script>

