<template>
    <div>
        <users
            entity="teacher"
            @set_editing_id="setEditingTeacher"
            @update_user="editTeacher"
            @openAddModal="$router.push('/user/roles')"
        >
            <span slot="entity_title">преподавателей</span>
            <div slot="user_additional_content">
                <div class="form-group">
                    <label>Фото</label>
                    <input ref="avatar"
                    type="file"
                    name="avatar"
                    :multiple="false"
                    class="form-control"
                    autocomplete="false">
                </div>
            </div>
            <span slot="table_additional_headers">
                <th class="text-capitalize align-middle text-center">Фото</th>
            </span>
            <template v-slot:table_additional_contents="{user}">
                <td>
                    <img :src="user.avatar_path" alt="Нет изображения" class="table__image">
                </td>
            </template>
        </users>
    </div>
</template>
<script>
import Users from './Users.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    components: { Users },
    name: 'teachers',
    data() {
        return {
            teacher: undefined,
        }
    },
    methods: {
        editTeacher(teacher) {
            console.log(teacher);
            //this.attachPhoto()
        },
        setEditingTeacher(teacher) {
            this.teacher = teacher
        },
        async attachPhoto() {
            let avatar = this.$refs.avatar.files[0]
            if(avatar) {
                let formData = new FormData()
                formData.append('avatar', avatar)
                await axios.post(`teacher/${this.teacher.id}/avatar`, formData)
                .then((response) => this.showSuccessMessage(response.data.data.message))
                .catch((error) => this.showFailMessage(error.response.data.data))
            }
        }
    },
    mixins: [notificationMixin]
}
</script>
<style lang="scss" scoped>
</style>
