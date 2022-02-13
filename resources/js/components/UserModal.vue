<template>
<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Cоздание пользователя</h5>
                    <h5 class="modal-title" v-show="editmode">Редактирование информации о пользователе</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? emitUpdateUser() : emitCreateUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Фамилия</label>
                            <input v-model="form.surname" type="text" name="surname"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('surname') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        
                        <div class="form-group">
                            <label>Имя</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        
                        <div class="form-group">
                            <label>Отчество</label>
                            <input v-model="form.patronymic" type="text" name="patronymic"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('patronymic') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Пароль</label>
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <slot name="modal_additional_content"></slot>
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
export default {
    name: 'user-modal',
    props: {
        form: {
            type: Object,
            default: () => {}
        },
        editmode: {
            type: Boolean,
            default: () => false
        }
    },
    watch: {
        '$props.form': () => {
            console.log(this.form);
        }
    },
    methods: {
        emitUpdateUser() {
            this.$emit('update_user', this.form)
        },
        emitCreateUser() {
            this.$emit('create_user')
        },
    },
}
</script>
