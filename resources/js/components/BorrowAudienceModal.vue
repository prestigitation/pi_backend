<template>
<div class="modal fade" id="borrowAudience" tabindex="-1" role="dialog" aria-labelledby="borrowAudience" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Занять аудиторию</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="borrowAudience()">
                    <div class="modal-body">
                        <input v-model="reason" placeholder="Укажите причину занятия аудитории">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Отправить</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>
<script>
export default {
    name: 'borrow-audience-modal',
    data() {
        return {
            reason: ''
        }
    },
    methods: {
        borrowAudience() {
            this.$emit('borrow-audience', this.reason)
        }
    }
}
</script>
