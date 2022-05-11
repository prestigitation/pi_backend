<template>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    Выбор даты
                </div>
                <div class="modal-body">
                    <div class="lead">Выберите дату, для получения информации о занятости аудиторий</div>
                    <input type="date" v-model="date" @change="$emit('change_date', date)">
                </div>
                <div class="modal-footer">
                    <span class="btn btn-success" @click.prevent="$emit('close_modal')">Закрыть</span>
                </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: 'empty-audience-date-modal',
    data() {
        return {
            date: new Date().toISOString()
        }
    }
}
</script>
