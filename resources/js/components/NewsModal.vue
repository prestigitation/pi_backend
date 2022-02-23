<template>
<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Добавление новости</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о новости</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateNews() : createNews()">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Заголовок новости</label>
                            <input v-model="form.title" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Категория</label>
                            <select name="type" v-model="form.category_id" id="type" class="form-control">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{category.name}}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Текст новости</label>
                            <wysiwyg v-model="form.description" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Изменить</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
export default {
    name: 'user-modal',
    data() {
        return {
            categories: []
        }
    },
    props: {
        editmode: {
            type: Boolean,
            default: () => false
        },
        form: {
            type: Object,
            default: () => {}
        },
        newsId: {
            type: Number,
        }
    },
    async mounted() {
        await axios.get(process.env.MIX_API_PATH + 'category')
            .then(({data}) => this.categories = data.data)
            .catch(() => this.showFailMessage('Не удалось загрузить категории новостей'))
    },
    methods: {
        async updateDirection() {
            await axios.put(process.env.MIX_DASHBOARD_PATH + `news/${this.newsId}`, this.form).then(() => {
                this.showSuccessMessage('Новость была успешно изменена')
            }).catch(() => {
                this.showFailMessage('Не удалось изменить данные о новости')
            }).finally(() => {
                this.$emit('close_direction_modal')
            })
        },
        async createNews() {
            await axios.post(process.env.MIX_DASHBOARD_PATH + 'news', this.form)
                .then(() => {
                    this.showSuccessMessage('Новость была успешно добавлена!')
                    this.$emit('close_direction_modal')
                }).catch(() => this.showFailMessage('Не удалось добавить новость'))
                .finally(() =>  this.$emit('close_direction_modal'))
        }
    },
    mixins: [notificationMixin]
}
</script>
