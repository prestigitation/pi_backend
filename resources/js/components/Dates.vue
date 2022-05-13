<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 d-flex flex-column justify-content-center">
                    <span class="title my-2 h2 lead">Изменение дат</span>
                    <label>Выберите новую дату начала семестра</label>
                    <input type="date" v-model="newSemesterStartDate">
                    <span v-if="semesterStartDate"> (На данный момент: {{new Date(semesterStartDate).toDateString()}})</span>
            </div>
        </div>
        <div class="btn btn-success my-2" @click.prevent="sendNewDates">
            Сохранить
        </div>
    </div>
</section>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
export default {
    name: 'dates',
    mixins: [notificationMixin],
    data() {
        return {
            semesterStartDate: null,
            newSemesterStartDate: null
        }
    },
    methods: {
        async getDatesInfo() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'dates').then(({data}) => {
                this.semesterStartDate = data.semester_start_date
            })
        },
        async sendNewDates() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'dates', {
                semester_start_date: this.newSemesterStartDate
            }).then(() => {
                this.showSuccessMessage('Даты были изменены!')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить даты')
            })
        }
    },
    async created() {
        await this.getDatesInfo()
    }
}
</script>
