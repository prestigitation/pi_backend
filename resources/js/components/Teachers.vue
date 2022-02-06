<template>
    <div>
        <users entity="teacher" @openAddModal="$router.push('/user/roles')">
            <span slot="entity_title">преподавателей</span>
        </users>
    </div>
</template>
<script>
import Users from './Users.vue'
export default {
    components: { Users },
    name: 'teachers',
}
</script>
<style lang="scss" scoped>
</style>
