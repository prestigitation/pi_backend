<template>
<span>{{pairNumber.number}} пара - c {{pairNumber.start}} до {{pairNumber.end}}</span>
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
