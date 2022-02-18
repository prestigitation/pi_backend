<template>
<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление направления</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о направлении</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? emitUpdateUser() : emitCreateUser()">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Код</label>
                            <input v-model="form.code" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Профиль</label>
                            <select name="type" v-model="form.profile" id="type" class="form-control">
                                <option v-for="profile in profiles" :key="profile.id" :value="profile.id">{{profile.name}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Форма обучения</label>
                            <select name="type" v-model="form.study_form" id="type" class="form-control">
                                <option v-for="study_form in study_forms" :key="study_form.id" :value="study_form.id">{{study_form.name}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Специальность</label>
                            <select name="type" v-model="form.speciality" id="type" class="form-control">
                                <option v-for="speciality in specialities" :key="speciality.id" :value="speciality.id">{{speciality.name}}</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="study_variants.length">
                            <label>Варианты обучения</label>
                            <span>
                                <button class="btn btn-primary btn-sm" @click.prevent="addNewVariant">
                                    Создать вариант обучения
                                </button>
                                <button class="btn btn-success btn-sm my-1" @click.prevent="pushVariant">
                                    Добавить вариант обучения
                                </button>
                            </span>
                            <select name="type" v-for="selectedVariants, index in form.study_variants" :key="selectedVariants" v-model="form.study_variants[index].id" id="type" class="my-2 form-control">
                                <option v-for="variant in study_variants" :key="variant.id" :value="variant.id">
                                    {{variant.years}} г. {{variant.months}} мес. {{variant.time_form.name}}
                                </option>
                            </select>
                        </div>

                        <slot name="modal_additional_content"></slot>
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
import StudyVariantCreate from './layout/StudyVariantCreate.vue'
import {notificationMixin} from '../mixins/notificationMixin'
export default {
    name: 'user-modal',
    components: {
        StudyVariantCreate
    },
    data() {
        return {
            form: new Form({
                    code: '',

                    study_form: 0,
                    speciality: 0,
                    profile: 0,
                    study_variants: [{}]
                }),
            study_forms: [],
            time_forms: [],
            profiles: [],
            specialities: [],
            study_variants: [],
            editmode: false
        }
    },
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        }
    },
    async mounted() {
        await axios.get(process.env.MIX_API_PATH + 'study_form')
            .then(({data}) => this.study_forms = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить формы обучения'))
        await axios.get(process.env.MIX_API_PATH + 'profile')
            .then(({data}) => this.profiles = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить профили подготовки'))
        await axios.get(process.env.MIX_API_PATH + 'speciality')
            .then(({data}) => this.specialities = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить специальности'))
        await axios.get(process.env.MIX_API_PATH + 'study_variant')
            .then(({data}) => this.study_variants = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить варианты обучения'))
    },
    methods: {
        addNewVariant() {
            this.$emit('close_direction_modal')
            this.$router.push('/study_variants')
        },
        pushVariant() {
            this.form.study_variants.push({id: 0})
        }
    },
    mixins: [notificationMixin]
}
</script>
