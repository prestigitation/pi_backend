<template>
<span>
    <span class="badge badge-primary mx-1" v-for="role in roles" :key="role.id">
        {{role.name}}
    </span>
</span>
</template>

<script>
export default {
    name: 'roles-data',
    props: {
        roles: {
            type: Array,
            default: () => []
        }
    }
}
</script>
