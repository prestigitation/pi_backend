<template>
<span>
    {{user.surname}} {{user.name}} {{user.patronymic}}
</span>
</template>
<script>
export default {
    name: 'user-name-data',
    props: {
        user: {
            type: Object,
            default: () => {}
        }
    }
}
</script>
