<template>
<span>
    <span class="link-primary" @click.prevent="$emit('pair_number_click', pairNumber.number)">{{pairNumber.number}}</span>
    <span>пара - c </span>
    <span class="link-primary" @click.prevent="$emit('pair_number_start_click', pairNumber.start)">{{pairNumber.start}}</span>
    <span>до</span>
    <span class="link-primary" @click.prevent="$emit('pair_number_end_click', pairNumber.end)">{{pairNumber.end}}</span>
</span>
</template>

<script>
export default {
    props: {
        pairNumber: {
            type: Object,
            default: () => {}
        }
    }
}
</script>
