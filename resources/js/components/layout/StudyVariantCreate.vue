<template>
<div class="study__variant-wrapper">
    <button class="btn btn-primary" @click.prevent="addVariant">
        Добавить вариант обучения
    </button>
    <span v-for="variant,index in variants" :key="index">
        {{variant}}
    </span>
</div>
</template>

<script>
export default {
    name: 'study-variant-create',
    data() {
        return {
            variants: [],
            variant_properties: {
                years: 0,
                months: 0,
                time_form: 0
            }
        }
    },
    props: {
        time_forms: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        addVariant() {
            this.variants.push(this.variant_properties)
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
