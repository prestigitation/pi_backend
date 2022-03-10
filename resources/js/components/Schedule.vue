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
                            <p class="mt-4">
                                <button class="btn btn-primary" type="button" @click.prevent="toggleFilterButton">
                                    Фильтрация +
                                </button>
                            </p>
                            <div class="collapse" id="filter__collapse">
                                <div class="card card-body">
                                    <span class="title lead my-2">Критерии фильтрации</span>
                                    {{filters}}
                                    <ul v-for="filter, index in filters" :key="index">
                                        <li class="lead">
                                            <span>{{filter.name}}:</span>
                                            <span v-for="value in filter.criterias">
                                                <span v-for="criteria, index in value">
                                                    <span>{{criteria}}</span>
                                                    <span v-show="filter.additionalInfo && filter.additionalInfo[index]">
                                                        ( {{ filter.additionalInfo[index] }} )
                                                    </span>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="btn btn-success" @click.prevent="filterSchedule">
                                        Отфильтровать
                                    </div>
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
                        <td>
                            <a href="#" class="link-primary">
                                {{schedule_data.group.name}}
                            </a>
                        </td>
                        <td>
                            <pair-number-presenter
                                :pairNumber="schedule_data.pair_number"
                                @pair_number_click="addPairNumberToFilter"
                                @pair_number_start_click="addPairStartTimeToFilter"
                                @pair_number_end_click="addPairEndTimeToFilter"
                            />
                        </td>
                        <td>
                            <a href="#" class="link-primary">
                                {{schedule_data.day.name}}
                            </a>
                        </td>
                        <td>
                            <div v-for="pair in schedule_data.pairs">
                                <pair-presenter
                                    :pair="pair"
                                    @pair_type_click="addPairTypeToFilter"
                                    @pair_subject_click="addPairSubjectToFilter"
                                    @pair_teacher_click="addPairTeacherToFilter"
                                    @pair_audience_click="addPairAudienceToFilter"
                                />
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
            filters: [],
            filterCollapseToggled: false,
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
        getFilterTemplate(name, query = undefined, entity, additionalInfo = undefined) {
            let template = {
                name,entity,additionalInfo: [], criterias: {}
            }

            if(additionalInfo) {
                template.additionalInfo = [additionalInfo]
            }

            if(query) {
                template.query = query
            }

            return template
        },
        moveToFilter(template, addingValue) {
            let matchedTemplate = this.filters.find((filter) =>
            filter.entity === template.entity &&
            filter.query === template.query &&
            filter.criterias[template.query].length)
            if(!matchedTemplate) {
                let queryObject = {...template }
                queryObject['criterias'][template.query] = [addingValue]
                this.filters.push(queryObject)
            } else if(!matchedTemplate.criterias[template.query].find(element => element === addingValue)) {
                matchedTemplate.criterias[template.query].push(addingValue)
                this.filters.push(matchedTemplate)
            } else {
                matchedTemplate.criterias = [addingValue]
                this.filters.push(matchedTemplate)
            }
        },
        addPairStartTimeToFilter(startTime) {
            let filterPartTemplate = this.getFilterTemplate('Дата начала','start', 'pair_number')
            this.moveToFilter(filterPartTemplate, startTime)
        },
        addPairEndTimeToFilter(endTime) {
            let filterPartTemplate = this.getFilterTemplate('Даты окончания','end', 'pair_number')
            this.moveToFilter(filterPartTemplate, endTime)
        },
        addPairNumberToFilter(pairNumber) {
            let filterPartTemplate = this.getFilterTemplate('Номера пар','number', 'pair_number')
            this.moveToFilter(filterPartTemplate, pairNumber)
        },
        addPairSubjectToFilter(subject) {
            console.log(subject);
            let filterPartTemplate = this.getFilterTemplate('Предметы','id', 'pair.subject')
            this.moveToFilter(filterPartTemplate, subject)
        },
        addPairTeacherToFilter(teacher) {
            let additionalInfo = `${teacher.user.surname} ${teacher.user.name} ${teacher.user.patronymic}`
            let filterPartTemplate = this.getFilterTemplate('Преподаватели','id', 'pair.teacher', additionalInfo)
            this.moveToFilter(filterPartTemplate, teacher.id)
        },
        addPairAudienceToFilter(audience) {
            let filterPartTemplate = this.getFilterTemplate('Аудитории', 'pair.audience')
            this.moveToFilter(filterPartTemplate, audience)
        },
        filterSchedule() {

        },
        toggleFilterButton() {
            this.filterCollapseToggled = !this.filterCollapseToggled
            if(this.filterCollapseToggled) {
                $('#filter__collapse').collapse('show')
            } else $('#filter__collapse').collapse('hide')
        },
    },
    async created() {
        await this.getSchedule()
    },
    watch: {
        filters : function (current, previous) {
            if(current.length > 0 && !this.filterCollapseToggled) {
                this.toggleFilterButton()
            }
        }
    }
}
</script>

