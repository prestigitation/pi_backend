<template>
<div class="modal fade" id="mySchedule" tabindex="-1" role="dialog" aria-labelledby="mySchedule" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Мое расписание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal__days" v-if="days.length">
                    <span class="modal__days-day" v-for="day, index in days" :key="day.id">
                        <span :class="['modal__days-day_name', {'modal__days-day_active': index === selectedDay}]" @click.prevent="setDay(index)">
                            {{day.name}}
                        </span>
                        <span class="modal__days-day_delimiter">
                                |
                        </span>
                    </span>
                </div>
                <div class="modal__schedule" v-if="daySchedule && mySchedule.length">
                    <div v-for="schedule in daySchedule" :key="schedule.id">
                        <span>
                            {{schedule.pair_number.number}} пара - {{schedule.group.name}}
                        </span>
                        <ul>
                            <li v-for="pair in JSON.parse(schedule.regularity)" v-if="getPairUserId(pair.teacher && pair.teacher.user && pair.teacher.user.id ? pair.teacher.user.id : undefined)">
                                <span>
                                    <span>{{pair.subject.name}}</span>
                                    <span v-if="pair.format">({{pair.format.name}})</span>
                                    <span>- {{pair.audience.name}} ауд.</span>
                                </span>
                                <span v-if="pair.type.value !== 'regular'">
                                    <span>{{pair.type.name}}</span>
                                    <span :style="'color: ' + pair.type.marker_color">*</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-else>
                    В этот день нет пар!
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
export default {
    name: 'self-schedule-modal',
    mixins: [notificationMixin],
    data() {
        return {
            mySchedule: [],
            days: [],
            selectedDay: 0
        }
    },
    methods: {
        async getMySchedule() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'schedules/me')
                .then(({data}) => this.mySchedule = data)
                .catch(() => this.showFailMessage('Не удалось загрузить расписание'))
        },
        async getDays() {
            await axios.get(process.env.MIX_API_PATH + 'days')
                .then(({data}) => this.days = data)
                .catch(() => this.showFailMessage('Не удалось загрузить дни недели'))
        },
        setDay(index) {
            this.selectedDay = index
        },
        getPairUserId(pairUserId) {
            return pairUserId === window.user.id
        }
    },
    async created() {
        await this.getDays();
        await this.getMySchedule();
    },
    computed: {
        daySchedule() {
            return this.mySchedule.filter((sch) => sch.day_id === this.selectedDay + 1)
        }
    }
}
</script>

<style lang="scss" scoped>
.modal {
    &__days {
        &-day {
            &_name {
                color: #007bff;
                &:hover {
                    cursor: pointer;
                }
            }
            &_active {
                color: black;
            }
        }
    }
}
</style>
