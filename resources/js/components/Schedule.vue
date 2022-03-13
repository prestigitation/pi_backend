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
                                    <ul v-for="filter, index in filters" :key="index">
                                        <li class="lead">
                                            <span>{{filter.name}}:</span>
                                            <span v-for="value in filter.criterias">
                                                <span v-for="criteria, index in value">
                                                    <span v-if="filter.additionalInfo && filter.additionalInfo[index]">
                                                        <span>
                                                            {{ filter.additionalInfo[index] }}
                                                        </span>
                                                        <span v-if="index !== value.length - 1">
                                                            ,
                                                        </span>
                                                    </span>
                                                    <span v-else>
                                                        <span>{{criteria}}</span>
                                                        <span v-if="index !== value.length - 1">
                                                            ,
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                    <div class="mx-auto">
                                        <div class="btn btn-success" @click.prevent="filterSchedule">
                                            Фильтрация
                                        </div>
                                        <div class="btn btn-warning" @click.prevent="resetFilter">
                                            Сбросить фильтры
                                        </div>
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
                            <a @click.prevent="addGroupToFilter(schedule_data.group)" href="#" class="link-primary">
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
                            <a @click.prevent="addDayToFilter(schedule_data.day)" href="#" class="link-primary">
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
                                    this.form.delete(`schedules/${scheduleId}`).then(async ()=>{
                                        this.showSuccessMessage('Часть расписания была успешно удалена!')
                                        await this.getSchedule();
                                    })
                            }
                        })
        },
        async getSchedule() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'schedules')
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
            filter.query === template.query)
            if(!matchedTemplate) {
                let queryObject = {...template }
                queryObject['criterias'][template.query] = [addingValue]
                this.filters.push(queryObject)
            } else if(matchedTemplate.criterias[template.query].length >= 0) {
                // если фильтр с подобным критерием уже существует, добавляем в него текущий элемент
                let templateIndex = this.filters.indexOf(matchedTemplate)
                if(!matchedTemplate.criterias[template.query].includes(addingValue)) {
                    matchedTemplate.criterias[template.query].push(addingValue)
                    if(template.additionalInfo.length === 1) {
                        matchedTemplate.additionalInfo.push(template.additionalInfo[0])
                    }
                    this.filters.splice(templateIndex, 1, matchedTemplate)
                }
            } else if(!matchedTemplate.criterias.length) {
                //если нету критериев, т.е criterias представлен как массив значений
                matchedTemplate.criterias = [addingValue]
                if(template.additionalInfo.length === 1) {
                    matchedTemplate.additionalInfo.push(template.additionalInfo[0])
                }
                this.filters.push(matchedTemplate)
            }
        },
        addPairStartTimeToFilter(startTime) {
            let filterPartTemplate = this.getFilterTemplate('Дата начала','start', 'pair_numbers')
            this.moveToFilter(filterPartTemplate, startTime)
        },
        addPairEndTimeToFilter(endTime) {
            let filterPartTemplate = this.getFilterTemplate('Даты окончания','end', 'pair_numbers')
            this.moveToFilter(filterPartTemplate, endTime)
        },
        addPairTypeToFilter(type) {
            let additionalInfo = `${type.name}`
            let filterPartTemplate = this.getFilterTemplate('Очередность проведения','id', 'pair_types', additionalInfo)
            this.moveToFilter(filterPartTemplate, type.id)
        },
        addPairNumberToFilter(pairNumber) {
            let filterPartTemplate = this.getFilterTemplate('Номера пар','number', 'pair_numbers')
            this.moveToFilter(filterPartTemplate, pairNumber)
        },
        addPairSubjectToFilter(subject) {
            let additionalInfo = `${subject.name}`
            let filterPartTemplate = this.getFilterTemplate('Предметы','id', 'pair_subjects', additionalInfo)
            this.moveToFilter(filterPartTemplate, subject.id)
        },
        addPairTeacherToFilter(teacher) {
            let additionalInfo = `${teacher.user.surname} ${teacher.user.name} ${teacher.user.patronymic}`
            let filterPartTemplate = this.getFilterTemplate('Преподаватели','id', 'pair_teachers', additionalInfo)
            this.moveToFilter(filterPartTemplate, teacher.id)
        },
        addDayToFilter(day) {
            let additionalInfo = `${day.name}`
            let filterPartTemplate = this.getFilterTemplate('Дни недели','id', 'days', additionalInfo)
            this.moveToFilter(filterPartTemplate, day.id)
        },
        addPairAudienceToFilter(audience) {
            let filterPartTemplate = this.getFilterTemplate('Аудитории', 'pair_audiences')
            this.moveToFilter(filterPartTemplate, audience)
        },
        addGroupToFilter(group) {
            let additionalInfo = `${group.name}`
            let filterPartTemplate = this.getFilterTemplate('Группы', 'id', 'pair_audiences', additionalInfo)
            this.moveToFilter(filterPartTemplate, group.id)
        },
        getFilter() {
            let filterParams = {}
            this.filters.forEach(filter => {
                if(filter.entity) {
                    filterParams[filter.entity] = filter.criterias
                } else filterParams[filter.query] = filter.criterias[filter.query]
            })
            return filterParams
        },
        filterSchedule() {
            let filter = this.getFilter()
            let form = new FormData()
            form.append('filter_string', JSON.stringify(filter))
            axios.post(process.env.MIX_API_PATH + 'schedules/filter', form)
            .then(({data}) => {
                this.schedules = data
            }).catch(e => {
                this.showFailMessage('Не удалось отфильтровать расписание!')
            }).finally(() => {
                this.toggleFilterButton()
            })
        },
        async resetFilter() {
            this.filters = []
            await this.getSchedule()
            this.toggleFilterButton()
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

