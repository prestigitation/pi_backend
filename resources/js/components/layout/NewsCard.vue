<template>
<div class="news__card m-4">
    <div class="news__card--image_block">
        <img class="news__card--image" :src="article.image">
    </div>
    <div class="news__card--content_block mt-2">
        <div class="d-flex justify-content-center align-items-center">
            <span class="h2 mx-2">{{ article.title }}</span>
            <span class="badge badge-primary">{{ article.category.name }}</span>
        </div>

        <div
            class="news__card--content_text d-flex justify-content-center align-items-center"
            v-html="article.description"
        />

        <div class="news__card--date">
            {{ new Date(article.created_at) }}
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'news-card',
    props: {
        article: {
            type: Object,
            default: () => {}
        }
    }
}
</script>

<style lang="scss" scoped>
.news {
    &__card {
        border: 1px solid black;
        padding: 10px;
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        &--content {
            &_text {
                height: 50px;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        }
        &--image {
            width: 150px;
            height: 100px;
        }
    }
}
</style>
