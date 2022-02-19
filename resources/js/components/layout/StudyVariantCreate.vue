<template>
<div class="study__variant-wrapper">
    <div class="row">
        <div class="col-10 col-lg-3 mx-4 study__variant-button d-flex flex-column">
            <div class="h2 lead title"> Добавить вариант обучения </div>
            <div class="mb-4">
                <input class="form-control my-2" v-model="variants.years" placeholder="Введите количество лет">
                <input class="form-control my-2" v-model="variants.months" placeholder="Введите количество месяцев(опционально)">
                <div>
                    <label for="type">Выберите форму обучения</label>
                    <select name="type" v-model="variants.time_form" id="type" class="form-control">
                        <option v-for="time_form in time_forms" :key="time_form.id" :value="time_form.id">{{time_form.name}}</option>
                    </select>
                </div>
            </div>
            <div class="btn btn-success" @click.prevent="sendVariant">
                Добавить
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {notificationMixin} from '../../mixins/notificationMixin'
export default {
    name: 'study-variant-create',
    data() {
        return {
            variants: {
                years: '',
                months: '',
                time_form: ''
            },
            time_forms: [],
            variant_properties: {
                years: '',
                months: '',
                time_form: ''
            },
        }
    },
    async mounted() {
        await axios.get(process.env.MIX_API_PATH + 'time_form')
            .then(({data}) => this.time_forms = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить специальности'))
    },
    methods: {
        async sendVariant() {
            let formData = new FormData()
            formData.append('years', this.variants.years)
            formData.append('months', this.variants.months)
            formData.append('time_form', this.variants.time_form)
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'study_variant', formData)
                .then(() => {
                    this.showSuccessMessage('Вариант был успешно добавлен!')
                })
                .catch(() => {
                    this.showFailMessage('Не удалось добавить данный вариант! Возможно, он уже существует.')
                })
        }
    },
    mixins: [notificationMixin]
}
</script>

<style lang="scss" scoped>
.study__variant {
    &-button:hover {
        cursor: pointer;
    }
}
</style>
