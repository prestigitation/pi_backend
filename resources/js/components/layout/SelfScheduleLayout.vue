<template>
<div class="ml-2 mt-1">
    <div class="modal__schedule" v-if="daySchedule.length">
        <div
            v-for="schedule in daySchedule" :key="schedule.id"
            v-if="JSON.parse(schedule.regularity).length"
        >
                <span>
                    <span>{{schedule.pair_number.number}} пара</span>
                    <span v-if="!$gate.isStudent()">- {{schedule.group.name}}</span>
                </span>
                <ul>
                    <li
                        v-for="pair in JSON.parse(schedule.regularity)"
                        v-if="getPairUserId(pair.teacher && pair.teacher.user && pair.teacher.user.id ? pair.teacher.user.id : undefined) && validPairsExist(pair)"
                    >
                        <span>
                            <span>{{pair.subject.name}}</span>
                            <span v-if="pair.format">({{pair.format.name}})</span>
                            <span>- {{pair.audience.name}} ауд.</span>
                            <span>- <UserNameData :user="pair.teacher.user ? pair.teacher.user : pair.teacher" /></span>
                        </span>
                            <span v-if="pair.type.value !== 'regular'">
                                <span>{{pair.type.name}}</span>
                            <span :style="'color: ' + pair.type.marker_color">*</span>
                        </span>
                        <a v-if="pair.teacher.study_link && $gate.isStudent()" :href="pair.teacher.study_link" class="btn btn-sm btn-info">Подключиться</a>
                </li>
            </ul>
        </div>
    </div>
    <div v-else>
        В этот день нет пар!
    </div>
</div>
</template>

<script>
import UserNameData from "./UserNameData.vue";
export default {
    name: "self-schedule-layout",
    props: {
        daySchedule: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        getPairUserId(pairUserId) {
            if (this.$gate.isTeacher()) {
                return pairUserId === window.user.id;
            }
            else
                return true;
        },
        validPairsExist: function (pair) {
            return this.$gate.isTeacher() ? pair.teacher.user.id === window.user.id : true;
        }
    },
    components: { UserNameData }
}
</script>
