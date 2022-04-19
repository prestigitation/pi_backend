<template>
<div class="ml-2 mt-1">
    <div class="modal__schedule" v-if="daySchedule.length">
        <div
            v-for="schedule in daySchedule" :key="schedule.id"
            v-if="schedule.regularity.length"
        >
                <span>
                    <span>{{schedule.pair_number.number}} пара</span>
                    <span v-if="!$gate.isStudent()">- {{schedule.group.name}}</span>
                </span>
                <ul>
                    <li
                        v-for="pair in schedule.regularity"
                        v-if="getPairUserId(pair.teacher && pair.teacher.user && pair.teacher.user.id ? pair.teacher.user.id : undefined) && validPairsExist(pair)"
                    >
                        <span>
                            <span>{{pair.subject.name}}</span>
                            <span v-if="pair.format">({{pair.format.name}})</span>
                            <span>- {{pair.audience.name}} ауд.</span>
                            <span>-
                                <span v-for="teacher in pair.teachers.length ? pair.teachers : pair.foreign_teachers">
                                    <UserNameData :user="teacher.user ? teacher.user : teacher" />
                                </span>
                            </span>
                        </span>
                            <span v-if="pair.type.value !== 'regular'">
                                <span>{{pair.type.name}}</span>
                            <span :style="'color: ' + pair.type.marker_color">*</span>
                        </span>
                        <a v-if="hasStudyLink(pair)" :href="getStudyLink(pair)" class="btn btn-sm btn-info">Подключиться</a>
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
        validPairsExist(pair) {
            return this.$gate.isTeacher() ? pair.teacher.user.id === window.user.id : true;
        },
        hasStudyLink(pair) {
            let hasLink = false
            if(pair.teachers.length > 0) {
                hasLink = pair.teachers[0].study_link
            } else if (pair.foreign_teachers.length > 0) {
                hasLink = pair.foreign_teachers[0].study_link
            }
            return hasLink && this.$gate.isStudent()
        },
        getStudyLink(pair) {
            if(pair.teachers.length > 0)
                return pair.teachers[0].study_link
            else if(pair.foreign_teachers.length > 0)
                return pair.foreign_teachers[0].study_link
        }
    },
    components: { UserNameData }
}
</script>
