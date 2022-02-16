<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список направлений
                        </slot>
                    </h3>

                <div class="card-tools">

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Наименование</th>
                            <th class="align-middle text-center">Код</th>
                            <th class="align-middle text-center">Профиль</th>
                            <th class="align-middle text-center">Квалификация</th>
                            <th class="align-middle text-center">Время обучения</th>
                            <th class="align-middle text-center">Форма обучения</th>
                            <th class="align-middle text-center">Форма оплаты</th>
                            <th class="align-middle text-center">Cоздан</th>
                        </slot>
                    </tr>
                </thead>
                <tbody>
                    xax

                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!--<div class="card-footer">
                <pagination :data="table_data ? table_data : users" @pagination-change-page="getResults"></pagination>
                </div>
            </div> -->
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <direction-modal
            @close_direction_modal="closeModal"
            id="addNew"
            :editmode="editmode"
            :form="form"
        />
    </div>
    </div>
</section>
</template>

<script>
import DirectionModal from './DirectionModal.vue'
export default {
    name: 'directions',
    components: {
        DirectionModal
    },
    methods: {
        newModal() {
            $('#addNew').modal('show');
        },
        closeModal() {
            $('#addNew').modal('toggle');
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
