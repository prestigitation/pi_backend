<template>
<span>
    <a href="#" class="{'link-primary': showLinks}" @click.prevent="$emit('pair_number_click', pairNumber.number)">{{pairNumber.number}}</a>
    <span>пара - c </span>
    <a href="#" class="{'link-primary': showLinks}" @click.prevent="$emit('pair_number_start_click', pairNumber.start)">{{pairNumber.start}}</a>
    <span>до</span>
    <a href="#" :class="{'link-primary': showLinks}" @click.prevent="$emit('pair_number_end_click', pairNumber.end)">{{pairNumber.end}}</a>
</span>
</template>

<script>
export default {
    props: {
        pairNumber: {
            type: Object,
            default: () => {}
        },
        showLinks: {
            type: Boolean,
            default : () => true
        }
    }
}
</script>
