<template>
<span class="mx-3 parity__wrapper" v-if="parity">
    <span class="lead h3">
        <span>Сейчас</span>
        <a href="#" :class="['text-lowercase', {'text-danger': parity.value === 'odd'},  {'text-info': parity.value === 'even'}]">{{parity.week}}</a> неделя
    </span>
</span>
</template>

<script>
import {notificationMixin} from '../../mixins/notificationMixin'
export default {
    name: 'parity',
    mixins: [notificationMixin],
    data() {
        return {
            parity: null
        }
    },
    methods: {
        async getParity() {
            await axios.get(process.env.MIX_DASHBOARD_PATH + 'time/parity')
                .then(({data}) => this.parity = data)
                .catch(() => this.showFailMessage('Не удалось загрузить четность недель'))
        }
    },
    async mounted() {
        await this.getParity()
    }
}
</script>
