<template>
<span class="pair">
    <span>
        <span v-if="pair.type.marker_color" :style="{'color': pair.type.marker_color}">
            *
        </span>
        <span>
            {{pair.type.name ? pair.type.name : ''}} -
        </span>
    </span>
    <span>
        {{pair.subject.name}} -
    </span>
    <user-name-data :user="pair.teacher.user" /> -
    <span>
        {{pair.audience}} аудитория
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
    }
}
</script>
