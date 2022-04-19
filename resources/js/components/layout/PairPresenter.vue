<template>
<span class="pair">
    <span>
        <span v-if="pair.type.marker_color" :style="{'color': pair.type.marker_color}">
            *
        </span>
        <a href="#" @click.prevent="$emit('pair_type_click', pair.type)" class="link-primary">
            {{pair.type.name ? pair.type.name : ''}}
        </a>
        <span>-</span>
    </span>
    <a @click.prevent="$emit('pair_subject_click', pair.subject)" href="#" class="link-primary">
        {{pair.subject.name}}
    </a>
    <span>-</span>
    <span v-if="pair.teachers.length">
        <span v-for="teacher, index in pair.teachers">
            <a @click.prevent="$emit('pair_teacher_click', teacher)" href="#" class="link-primary">
                <user-name-data :user="teacher.user" />
            </a>
            <span v-if="index !== pair.teachers.length - 1">
                ,
            </span>
        </span>
    </span>
    <span v-else-if="pair.foreign_teachers">
        <span v-for="teacher, index in pair.foreign_teachers">
            <a @click.prevent="$emit('pair_teacher_click', teacher)" href="#" class="link-primary">
                <user-name-data :user="teacher" />
            </a>
            <span v-if="index !== pair.foreign_teachers.length - 1">
                ,
            </span>
        </span>
    </span>
    <span>-</span>
    <a @click.prevent="$emit('pair_audience_click', pair.audience)" href="#" class="link-primary">
        {{pair.audience.name}} аудитория
    </a>
    <span v-if="pair.study_process">
        <span>-</span>
        <a @click.prevent="$emit('pair_process_click', pair.study_process)" href="#" class="link-primary">
            {{pair.study_process.name}}
        </a>
    </span>
</span>
</template>

<script>
import UserNameData from './UserNameData.vue'
export default {
    name: 'pair-presenter',
    components: {
        UserNameData
    },
    props: {
        pair: {
            type: Object,
            default: () => {}
        }
    },
}
</script>
