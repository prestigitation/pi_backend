<template>
<div class="audience__wrapper" v-if="audience_data">
    <div v-for="(audience, index) in audience_data" :key="audience.id">
        <div v-if="audience.empty.length || audience.busy.length">
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
                />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import EmptyAudienceTemplate from "./EmptyAudienceTemplate.vue";
export default {
    name: "empty-audiences-layout",
    props: ['audience_data'],
    components: { EmptyAudienceTemplate }
}
</script>

<style lang="scss" scoped>

</style>
