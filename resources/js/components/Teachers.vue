<template>
    <div>
        <users entity="teacher" :update_user="attachPhoto" @openAddModal="$router.push('/user/roles')">
            <span slot="entity_title">преподавателей</span>
            <div slot="user_additional_content">
                <div class="form-group">
                    <label>Фото</label>
                    <input ref="avatar"
                    @change="setFile"
                    type="file"
                    name="avatar"
                    :multiple="false"
                    class="form-control"
                    autocomplete="false">
                </div>
            </div>
        </users>
    </div>
</template>
<script>
import Users from './Users.vue'
export default {
    components: { Users },
    name: 'teachers',
    data() {
        return {
            avatar: undefined
        }
    },
    methods: {
        setFile(e) {
            console.log(e);
        },
        attachPhoto() {
            console.log('emit');
        }
    }
}
</script>
<style lang="scss" scoped>
</style>
