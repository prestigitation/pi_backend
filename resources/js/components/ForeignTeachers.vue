<template>
    <div>
        <users
            entity="foreign_teachers"
            @set_editing_id="setEditingTeacher"
            @openAddModal="$router.push('/user/roles')"
            :custom_form="form"
            :update_user="updateTeacher"
        >
            <template #password></template>
            <template #email></template>

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
                        <label>Должность</label>
                        <select name="type" v-model="form.position" id="type" class="form-control">
                            <option v-for="position, index in positions" :key="index" :value="position">
                                {{position}}
                            </option>
                        </select>
                    </div>
            </div>

            <template #table_header>
                <th class="text-capitalize align-middle text-center">ID</th>
                <th class="text-capitalize align-middle text-center">Изображение</th>
                <th class="text-capitalize align-middle text-center">Фамилия</th>
                <th class="text-capitalize align-middle text-center">Имя</th>
                <th class="text-capitalize align-middle text-center">Отчество</th>
                <th class="text-capitalize align-middle text-center">Должность</th>
                <th class="text-capitalize align-middle text-center">Cоздан</th>
                <th class="text-capitalize align-middle text-center">Действия</th>
            </template>

            <span slot="table_additional_headers">
                <th class="text-capitalize align-middle text-center">Фото</th>
            </span>

            <template #table_additional_contents="{user}">
                <td>
                    <img :src="user.avatar_path" alt="Нет изображения" class="table__image">
                </td>
            </template>

            <template #table_content_id = "{user: teacher}">
                {{teacher.id}}
            </template>

            <template #table_content_name = "{user: teacher}">
                {{teacher.name}}
            </template>

            <template #table_content_surname = "{user: teacher}">
                {{teacher.surname}}
            </template>

            <template #table_content_patronymic = "{user: teacher}">
                {{teacher.patronymic}}
            </template>

            <template #table_content_email>
            </template>


            <template #table_content_created_at = "{user: teacher}">
                {{teacher.created_at}}
            </template>

            <template #table_content_roles = "{user: teacher}">
                {{teacher.position}}
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
    name: 'foreign-teachers',
    data() {
        return {
            form: new Form({
                id : '',
                name: '',
                surname: '',
                patronymic: '',
                position: ''
            }),
            positions: []
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
        async updateTeacher() {
            let teacher = this.teachers.find(teacher => teacher.user.id === this.teacher.id)
            await axios.put(process.env.MIX_DASHBOARD_PATH + 'teachers/' + teacher.id, this.teacher)
                .then(() => {
                    this.showSuccessMessage('Информация была успешно обновлена!')
                    this.getTeachers()
                })
                .catch(() => this.showFailMessage('Не удалось обновить информацию о преподавателе'))
        },
        async attachPhoto() {
            let avatar = this.$refs.avatar.files[0]
            if(avatar) {
                let formData = new FormData()
                formData.append('avatar', avatar)
                await axios.post(`foreign_teachers/${this.teacher.id}/avatar`, formData)
                .then((response) => this.showSuccessMessage(response.data.data.message))
                .catch((error) => this.showFailMessage(error.response.data.data))
            }
        },
        async getPositions() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'positions/all').then(({data}) => this.positions = data)
        },
    },
    async created() {
        await this.getPositions()
    },
    mixins: [notificationMixin]
}
</script>
