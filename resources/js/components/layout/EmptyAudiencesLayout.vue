<template>
<div class="audience__wrapper" v-if="audience_data">
    <div v-for="(audience, index) in audience_data" :key="audience.id">
        <div>
            <div class="lead h3 d-flex justify-content-center">{{ index }} пара</div>
            <div class="audience__variants mb-3">
                <div class="my-2"><u>Занятые аудитории:</u></div>
                <EmptyAudienceTemplate
                    v-for="aud in audience.busy"
                    :key="aud.id"
                    :audience="aud"
                    button_type="danger"
                />
                <div class="my-2"><u>Свободные аудитории:</u></div>
                <EmptyAudienceTemplate
                    v-for="aud in audience.empty"
                    :key="aud.id"
                    :audience="aud"
                    button_type="success"
                    @button-click="borrowAudience(aud.id, index)"
                />
            </div>
        </div>
    </div>

    <BorrowAudienceModal
        id="borrowAudience"
        @borrow_audience="sendBorrowedAudience"
    />
</div>
</template>

<script>
import EmptyAudienceTemplate from "./EmptyAudienceTemplate.vue";
import BorrowAudienceModal from "../BorrowAudienceModal.vue";
import {notificationMixin} from '../../mixins/notificationMixin'
export default {
    name: "empty-audiences-layout",
    props: ['audience_data'],
    mixins: [notificationMixin],
    components: { EmptyAudienceTemplate, BorrowAudienceModal },
    data() {
        return {
            currentAudienceId: '',
            currentPairNumberId: ''
        }
    },
    inject: [
        'currentDate'
    ],
    methods: {
        borrowAudience(audienceId, pairNumberId) {
            $('#borrowAudience').modal('show')
            this.currentAudienceId = audienceId
            this.pairNumberId = pairNumberId
        },
        async sendBorrowedAudience(reason) {
            let form = new FormData()
            form.append('reason', reason)
            if(this.currentDate) {
                form.append('date', this.currentDate)
            }
            await axios.post(process.env.MIX_DASHBOARD_PATH + `audience/${this.currentAudienceId}/pair_number/${this.pairNumberId}`, form)
                .then(() => this.showSuccessMessage('Аудитория была забронирована!'))
                .catch(() => this.showFailMessage('Не удалось забронировать аудиторию!'))
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
