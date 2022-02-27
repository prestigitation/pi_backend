<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список новостей
                        </slot>
                    </h3>

                <div class="card-tools">

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Заголовок</th>
                            <th class="align-middle text-center">Категория</th>
                            <th class="align-middle text-center">Текст статьи</th>
                            <th class="align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="news_data in news" :key="news_data.id">
                        <td>
                            {{news_data.id}}
                        </td>
                        <td>
                            {{news_data.title}}
                        </td>
                        <td class="text-truncate">
                            {{news_data.category.name}}
                        </td>
                        <td>
                            {{news_data.description}}
                        </td>
                        <td>
                            <a href="#" @click="editNews(news_data)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            /
                            <a href="#" @click="deleteNews(news_data.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer" v-if="news && news.length">
                <pagination :data="news" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <news-modal
            @close_direction_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form="form"
            :newsId="newsId"
        />
    </div>
    </div>
</section>
</template>

<script>
import NewsModal from './NewsModal.vue'
import { notificationMixin } from '../mixins/notificationMixin'
export default {
    name: 'news',
    mixins: [notificationMixin],
    components: {
        NewsModal
    },
    data() {
        return {
            news: [],
            newsId: 1,
            editmode: false,
            form: new Form({
                title: '',
                category_id: 1,
                description: ''
            }),
        }
    },
    methods: {
        newModal() {
            this.editmode = false
            this.newsId = null
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
            this.getNews()
        },
        editNews(news) {
            this.newsId = news.id
            this.editmode = true
            this.form.fill(news)
            $('#addNew').modal('show');
        },
        async deleteNews(newsId) {
            Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить данную новость?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then(async (result) => {
                            if (result.value) {
                                    this.form.delete(`news/${newsId}`).then(async ()=>{
                                        this.showSuccessMessage('Новость была успешно удалена!')
                                        await this.getNews();
                                    })
                            }
                        })
        },
        async getNews() {
            await axios.get(process.env.MIX_API_PATH + 'news')
                .then(({data}) => this.news = data.data)
                .catch(() => this.showFailMessage('Не удалось загрузить новости'))
        }
    },
    async created() {
        await this.getNews()
    }
}
</script>

