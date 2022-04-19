<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 dashboard__info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <svg width="50" height="50" fill="black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M592 0h-384C181.5 0 160 22.25 160 49.63V96c23.42 0 45.1 6.781 63.1 17.81V64h352v288h-64V304c0-8.838-7.164-16-16-16h-96c-8.836 0-16 7.162-16 16V352H287.3c22.07 16.48 39.54 38.5 50.76 64h253.9C618.5 416 640 393.8 640 366.4V49.63C640 22.25 618.5 0 592 0zM160 320c53.02 0 96-42.98 96-96c0-53.02-42.98-96-96-96C106.1 128 64 170.1 64 224C64 277 106.1 320 160 320zM192 352H128c-70.69 0-128 57.31-128 128c0 17.67 14.33 32 32 32h256c17.67 0 32-14.33 32-32C320 409.3 262.7 352 192 352z"/></svg>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Преподаватели</span>
                            <span>
                                <a @click.prevent="$router.push('/teachers')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{header_info.teachers_count.department }} с нашей кафедры</span>
                                </a>
                                <a @click.prevent="$router.push('/foreign_teachers')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{header_info.teachers_count.foreign }} с других кафедр</span>
                                </a>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 dashboard__info-box">
                        <span class="info-box-icon bg-primary elevation-1">
                            <svg width="50" height="50" fill="lightblue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M96 0C113.7 0 128 14.33 128 32V64H480C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H128V480C128 497.7 113.7 512 96 512C78.33 512 64 497.7 64 480V128H32C14.33 128 0 113.7 0 96C0 78.33 14.33 64 32 64H64V32C64 14.33 78.33 0 96 0zM448 160C465.7 160 480 174.3 480 192V352C480 369.7 465.7 384 448 384H192C174.3 384 160 369.7 160 352V192C160 174.3 174.3 160 192 160H448z"/></svg>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Направления</span>
                            <span class="info-box-number">
                                <a @click.prevent="$router.push('/directions')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{header_info.directions_count }} направлений обучения</span>
                                </a>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 dashboard__info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Группы</span>
                            <span class="info-box-number">
                                <a @click.prevent="$router.push('/groups')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{header_info.groups_count }} групп</span>
                                </a>
                            </span>
                        </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box dashboard__info-box">
                        <span class="info-box-icon bg-red elevation-1">
                            <svg width="50" height="50" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M204.3 32.01H96c-52.94 0-96 43.06-96 96c0 17.67 14.31 31.1 32 31.1s32-14.32 32-31.1c0-17.64 14.34-32 32-32h108.3C232.8 96.01 256 119.2 256 147.8c0 19.72-10.97 37.47-30.5 47.33L127.8 252.4C117.1 258.2 112 268.7 112 280v40c0 17.67 14.31 31.99 32 31.99s32-14.32 32-31.99V298.3L256 251.3c39.47-19.75 64-59.42 64-103.5C320 83.95 268.1 32.01 204.3 32.01zM144 400c-22.09 0-40 17.91-40 40s17.91 39.1 40 39.1s40-17.9 40-39.1S166.1 400 144 400z"/></svg>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Вопрос/ответ</span>
                            <span class="info-box-number">
                                <a @click.prevent="$router.push('/questions')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{ header_info.questions_count.all }} всего</span>
                                </a>
                                <a @click.prevent="$router.push('/questions')" class="dashboard__link link-primary">
                                    <span class="info-box-number">{{ header_info.questions_count.all - header_info.questions_count.answered }} не отвечено</span>
                                </a>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card" v-if="header_info.today_schedule && header_info.today_schedule.length">
                    <div class="card-header">
                        <h3 class="card-title">Расписание на сегодня</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <SelfScheduleLayout :daySchedule="header_info.today_schedule" />
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->

                <div class="card" v-if="header_info.last_news && header_info.last_news.length">
                    <div class="card-header">
                        <h3 class="card-title">Последние новости</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <tbody class="text-center d-flex">
                            <NewsCard v-for="article in header_info.last_news" :key="article.id" :article="article" />
                        </tbody>
                    </div>
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span>Свободные аудитории</span>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <EmptyAudiencesLayout />
                    </div>
                <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</template>

<script>
import {notificationMixin} from '../mixins/notificationMixin'
import SelfScheduleLayout from './layout/SelfScheduleLayout.vue'
import EmptyAudiencesLayout from './layout/EmptyAudiencesLayout'
import NewsCard from './layout/NewsCard.vue';
export default {
    name: "dashboard",
    mixins: [
        notificationMixin
    ],
    data() {
        return {
            header_info: {}
        };
    },
    async mounted() {
        await axios.get(process.env.MIX_DASHBOARD_PATH + "header_info")
            .then(({ data }) => this.header_info = data)
            .catch(() => this.showFailMessage("Не удалось загрузить информацию для админ-панели!"));
    },
    components: {
        SelfScheduleLayout,
        NewsCard,
        EmptyAudiencesLayout
    }
}
</script>
