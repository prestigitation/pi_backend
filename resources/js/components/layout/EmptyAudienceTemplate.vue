<template>
<span :class="['btn', 'p-1', 'mx-1', `btn-${button_type}`]">
    {{ audience.name }}
</span>
</template>

<script>
export default {
    name: 'empty-audience-template',
    props: {
        audience: {
            type: Object,
            default: () => {}
        },
        button_type: {
            type: String,
            default: '',
        }
    }
}
</script>
