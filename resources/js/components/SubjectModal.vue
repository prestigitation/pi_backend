<template>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление записи о предмете</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о предмете</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="editmode ? updateSubject() : createSubject()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Наименование</label>
                            <input v-model="form.name" type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Преподаватели с нашей кафедры, читающие данный предмет</label>
                            <ul>
                                <li v-for="teacher, index in form.teachers" :key="teacher.id">
                                    <user-name-data :user="teacher.user" />
                                    <span @click.prevent="clearTeacher(index)">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM168 232C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H168z"/></svg>
                                    </span>
                                </li>
                            </ul>
                            <select name="type" v-model="teach" id="type" class="form-control">
                                <option v-for="teacher in teachers['teachers']" :key="teacher.id" :value="teacher">
                                    <user-name-data :user="teacher.user" />
                                </option>
                            </select>
                            <div class="btn btn-success my-2 mx-auto d-flex justify-content-center w-50" @click.prevent="addTeacherToSubject('teachers')">
                                Добавить
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Преподаватели с других кафедр, читающие данный предмет</label>
                            <ul>
                                <li v-for="teacher, index in form.foreign_teachers" :key="teacher.id">
                                    <user-name-data :user="teacher" />
                                    <span @click.prevent="clearTeacher(index, 'foreign_teachers')">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM168 232C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H168z"/></svg>
                                    </span>
                                </li>
                            </ul>
                            <select name="type" v-model="foreignTeacher" id="type" class="form-control">
                                <option v-for="teacher in teachers['foreign_teachers']" :key="teacher.id" :value="teacher">
                                    <user-name-data :user="teacher" />
                                </option>
                            </select>
                            <div class="btn btn-success my-2 mx-auto d-flex justify-content-center w-50" @click.prevent="addTeacherToSubject('foreign_teachers')">
                                Добавить
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Изменить</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>

<script>
import UserNameData from './layout/UserNameData.vue'
export default {
    name: "group-modal",
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => { }
        },
        subjectId: {
            type: Number,
        },
    },
    data() {
        return {
            teachers: [],
            teach: 1,
            foreignTeacher: 1
        }
    },
    async created() {
        await this.getTeachers()
        await this.getForeignTeachers()
    },
    methods: {
        async updateSubject() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `subjects/${this.subjectId}`, this.form).then(() => {
                this.showSuccessMessage("Предмет был успешно изменен");
            }).catch(() => {
                this.showFailMessage("Не удалось изменить данные о предмете");
            }).finally(async () => {
                this.$emit("close_subject_modal");
            });
        },
        async createSubject() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + "subjects", this.form)
                .then(() => {
                this.showSuccessMessage("Предмет был успешно добавлен!");
            }).catch(() => this.showFailMessage("Не удалось добавить предмет"))
                .finally(() => { this.$emit("close_subject_modal") });
        },
        async getTeachers(entity = 'teachers') {
            await axios.get(process.env.MIX_DASHBOARD_PATH + `${entity}/all`).then(({data}) => {
                this.teachers[entity] = data
            }).catch(() => {
                this.showFailMessage(`Не удалось загрузить данные по ${entity}`)
            })
        },
        async getForeignTeachers() {
            await this.getTeachers('foreign_teachers')
        },
        addTeacherToSubject(teacherType) {
            let teacher = this.teach
            if(teacherType == 'foreign_teachers') {
                teacher = this.foreignTeacher
            }
            this.form[teacherType].push(teacher)
        },
        clearTeacher(index, type = 'teachers') {
            if(type) {
                this.form[type].splice(index, 1)
            }
        }
    },
    components: { UserNameData }
}
</script>

<style lang="scss" scoped>
.pair {
    &__selector {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    &__wrapper {
        background: lightgray;
    }
    &__button:hover {
        cursor: pointer;
    }
}

</style>
