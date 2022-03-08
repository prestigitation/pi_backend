<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            <div>
                                Таблица расписания
                            </div>
                            <p class="mt-2">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    Фильтрация +
                                </button>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <!--<div v-for="filter, index in filters" :key="index">
                                        <span class="lead">{{filter.name}}:</span>
                                    </div> -->
                                    {{filters}}
                                </div>
                            </div>
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
                        <td class="link-primary">
                            {{schedule_data.group.name}}
                        </td>
                        <td>
                            <pair-number-presenter
                                :pairNumber="schedule_data.pair_number"
                                @pair_number_click="addPairNumberToFilter"
                                @pair_number_start_click="addPairStartTimeToFilter"
                                @pair_number_end_click="addPairEndTimeToFilter"
                            />
                        </td>
                        <td class="link-primary">
                            {{schedule_data.day.name}}
                        </td>
                        <td class="link-primary">
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
            <div class="card-footer" v-if="schedules && schedules.length">
                <pagination :data="schedules" @pagination-change-page="getResults"></pagination>
            </div>
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
            scheduleId: null,
            filters: []
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
        getFilterTemplate(name, entity, query, values = undefined) {
            let template = {
                name,query,entity
            }
            if(values) {
                template.values = values
            }

            return template
        },
        moveToFilter(template, addingValue) {
            let matchedTemplate = this.filters.find((filter) => filter.entity === template.entity && filter.query === template.query)
            if(!matchedTemplate) {
                this.filters.push({...template, values: [addingValue]})
            } else {
                if(!matchedTemplate.values.find(element => element === addingValue)) {
                    matchedTemplate.values.push(addingValue)
                }
            }
        },
        addPairStartTimeToFilter(startTime) {
            let filterPartTemplate = this.getFilterTemplate('Дата начала','start', 'pair_number')
            this.moveToFilter(filterPartTemplate, startTime)
        },
        addPairEndTimeToFilter(endTime) {
            let filterPartTemplate = this.getFilterTemplate('Дата окончания','end', 'pair_number')
            this.moveToFilter(filterPartTemplate, endTime)
        },
        addPairNumberToFilter(pairNumber) {
            let filterPartTemplate = this.getFilterTemplate('Номер пары','number', 'pair_number')
            this.moveToFilter(filterPartTemplate, pairNumber)
        }
    },
    async created() {
        await this.getSchedule()
    }
}
</script>

