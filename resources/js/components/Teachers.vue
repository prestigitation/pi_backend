<template>
    <div>
        <users
            entity="teachers"
            @set_editing_id="setEditingTeacher"
            @openAddModal="$router.push('/user/roles')"
            :custom_form="form"
            :update_user="updateTeacher"
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
                    <div class="form-group">
                        <label>Количество публикаций</label>
                        <input v-model="form.publications_count" type="text" name="publications_count" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Ссылка для проведения пар(оцпицонально)</label>
                        <input v-model="form.study_link" type="text" name="study_link" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Количество конференций</label>
                        <input v-model="form.conferences_count" type="text" name="conferences_count" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Количество проектов</label>
                        <input v-model="form.projects_count" type="text" name="projects_count" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Количество дипломных проектов</label>
                        <input v-model="form.diploma_projects_count" type="text" name="projects_count" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Профессиональные интересы</label>
                        <wysiwyg v-model="form.professional_interests" />
                    </div>
                    <div class="form-group">
                        <label>Защита диссертации</label>
                        <wysiwyg v-model="form.dissertation_proof" />
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
                study_link: '',
                email: '',
                password: '',
                dissertation_proof: '',
	            professional_interests: '',
                education_level_id: 1,
                diploma_projects_count: null,
                projects_count: null,
                conferences_count: null,
                publications_count: null,
            }),
            teacher: undefined,
            teachers: [],
            educationLevels: [],
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
                await axios.post(`teachers/${this.teacher.id}/avatar`, formData)
                .then((response) => this.showSuccessMessage(response.data.data.message))
                .catch((error) => this.showFailMessage(error.response.data.data))
            }
        },
        async getEducationLevels() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'education_levels/all').then(({data}) => this.educationLevels = data.data)
        },
        async getTeachers() {
            await axios.get(process.env.MIX_API_PATH + 'teachers').then(({data}) => this.teachers = data)
        }
    },
    async created() {
        await this.getEducationLevels()
        await this.getTeachers()
    },
    mixins: [notificationMixin]
}
</script>
