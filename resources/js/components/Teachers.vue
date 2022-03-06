<template>
    <div>
        <users
            entity="teacher"
            @set_editing_id="setEditingTeacher"
            @openAddModal="$router.push('/user/roles')"
            :custom_form="form"
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
                <div class="form-group">
                    <label>Образование</label>
                    <select name="type" v-model="form.education_level_id" id="type" class="form-control">
                        <option v-for="level in educationLevels" :key="level.id" :value="level.id">
                            {{level.name}}
                        </option>
                    </select>
                </div>
            </div>

            <span slot="table_additional_headers">
                <th class="text-capitalize align-middle text-center">Фото</th>
            </span>

            <template #table_additional_contents="{user}">
                <td>
                    <img :src="user.avatar_path" alt="Нет изображения" class="table__image">
                </td>
            </template>

            <template #table_content_id = "{user: teacher}">
                {{teacher.user_id}}
            </template>

            <template #table_content_name = "{user: teacher}">
                {{teacher.user.name}}
            </template>

            <template #table_content_surname = "{user: teacher}">
                {{teacher.user.surname}}
            </template>

            <template #table_content_patronymic = "{user: teacher}">
                {{teacher.user.patronymic}}
            </template>

            <template #table_content_email = "{user: teacher}">
                {{teacher.user.email}}
            </template>

            <template #table_content_created_at = "{user: teacher}">
                {{teacher.user.created_at}}
            </template>

            <template #table_content_roles = "{user: teacher}">
                <roles-data :roles="teacher.user.roles" />
            </template>
        </users>
    </div>
</template>
<script>
import Users from './Users.vue'
import RolesData from './layout/RolesData.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    components: { Users, RolesData },
    name: 'teachers',
    data() {
        return {
            form: new Form({
                id : '',
                name: '',
                surname: '',
                patronymic: '',
                email: '',
                password: '', //TODO: композиция форм
                education_level_id: 1
            }),
            teacher: undefined,
            educationLevels: []
        }
    },
    methods: {
        editTeacher(teacher) {
            this.attachPhoto()
        },
        setEditingTeacher(teacher) {
            let mergedTeacher = Object.assign(this.form, teacher.user)
            this.teacher = mergedTeacher
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
        },
        async getEducationLevels() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'education_level/all').then(({data}) => this.educationLevels = data.data)
        }
    },
    async created() {
        await this.getEducationLevels()
    },
    mixins: [notificationMixin]
}
</script>
