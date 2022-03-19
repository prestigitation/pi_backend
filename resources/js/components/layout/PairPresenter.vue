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
    <a @click.prevent="$emit('pair_teacher_click', pair.teacher)" href="#" class="link-primary">
        <user-name-data :user="pair.teacher.user ? pair.teacher.user : pair.teacher" />
    </a>
    <span>-</span>
    <a @click.prevent="$emit('pair_audience_click', pair.audience)" href="#" class="link-primary">
        {{pair.audience.name}} аудитория
    </a>
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
