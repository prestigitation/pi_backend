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
                        <span class="modal__days-day_delimiter" v-if="index !== days.length - 1">
                                |
                        </span>
                    </span>
                </div>
                <SelfScheduleLayout :daySchedule="daySchedule" />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
import SelfScheduleLayout from './layout/SelfScheduleLayout.vue'
export default {
    name: "self-schedule-modal",
    mixins: [notificationMixin],
    data() {
        return {
            mySchedule: [],
            days: [],
            selectedDay: 0
        };
    },
    methods: {
        async getMySchedule() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + "schedules/me")
                .then(({ data }) => this.mySchedule = data)
                .catch(() => this.showFailMessage("Не удалось загрузить расписание"));
        },
        async getDays() {
            await axios.get(process.env.MIX_API_PATH + "days")
                .then(({ data }) => this.days = data)
                .catch(() => this.showFailMessage("Не удалось загрузить дни недели"));
        },
        setDay(index) {
            this.selectedDay = index;
        },
    },
    async created() {
        if (this.$gate.isTeacher() || this.$gate.isStudent()) {
            await this.getDays();
            await this.getMySchedule();
        }
    },
    computed: {
        daySchedule() {
            return this.mySchedule.filter((sch) => sch.day_id === this.selectedDay + 1);
        }
    },
    components: { SelfScheduleLayout }
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
