<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex flex-column justify-content-center">
                <span class="title my-2">Просмотр ролей пользователей</span>
                <form method="POST" class="d-flex flex-column justify-content-center">
                    <input type="text" v-model="user.id" class="form-control col-lg-3 my-2" aria-describedby="usersRoles" placeholder="Введите ID пользователя">
                    <input type="text" v-model="user.name" class="form-control  col-lg-3 my-1" aria-describedby="usersRoles" placeholder="Введите имя пользователя">
                    <input type="text" v-model="user.surname" class="form-control col-lg-3 my-1" aria-describedby="usersRoles" placeholder="Введите фамилию пользователя">
                    <input type="text" v-model="user.patronymic" class="form-control col-lg-3 my-1" aria-describedby="usersRoles" placeholder="Введите отчество пользователя">
                </form>
            </div>
        </div>
        <button class="btn btn-success my-lg-4 my-1 col-3 mx-auto" @click.prevent="findUser">Найти</button>
        <div v-if="foundUsers">
            <span class="row d-flex justify-content-center lead h3 mb-2 title"> Результаты поиска по вашему запросу </span>
            <users :table_data="foundUsers" @set_editing_id="setEditingUser">
                <span slot="table_actions">
                    <button class="btn btn-success" @click.prevent="openUserRoles">
                        Роли + x
                    </button>
                </span>
                <span slot="table_title">
                    Найденные пользователи
                </span>
            </users>
        </div>
    </div>



    <div class="modal fade" id="roles" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content pl-3 pt-3">
                    <div class="title lead">
                        Редактирование ролей
                    </div>
                    <div class="modal__inner" v-if="currentUser">
                        <span class="lead">Список ролей пользователя {{ currentUser.name ? currentUser.name : ''}} {{ currentUser.surname ? currentUser.surname : ''}} {{ currentUser.patronymic ? currentUser.patronymic : ''}}</span>
                        <div class="mx-1 my-1">
                            <span class="badge badge-info text-white mx-1 p-1" v-for="role in currentUser.roles" :key="role.id">
                                <span>{{role.name}}</span>
                            </span>
                        </div>
                        <div class="form-group px-2">
                            <label>Изменение роли пользователя</label>
                            <select name="type" v-model="attached_role" id="type" class="form-control">
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center my-1">
                            <button class="btn btn-success mx-1" @click.prevent="attachRole">
                                Добавить роль
                            </button>
                            <button class="btn btn-danger mx-1" @click.prevent="detachRole">
                                Отвязать роль
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
</section>
</template>
<script>
import axios from "axios"
import Users from "./Users.vue"

import { notificationMixin } from '../mixins/notificationMixin'

export default {
    name: "users-roles",
    data() {
        return {
            user: {
                id: "",
                name: "",
                surname: "",
                patronymic: ""
            },
            attached_role: 1,
            roles: [],
            foundUsers: undefined,
            currentUser: undefined
        };
    },
    created() {
        axios.get("role").then(({ data }) => {
            this.roles = data.data
        });
    },
    methods: {
        findUser() {
            let formData = new FormData();
            if (this.user.id)
                formData.append("id", this.user.id);
            if (this.user.name)
                formData.append("name", this.user.name);
            if (this.user.surname)
                formData.append("surname", this.user.surname);
            if (this.user.patronymic)
                formData.append("patronymic", this.user.patronymic);
            axios.post("user/search", formData).then(({ data }) => {
                this.foundUsers = data
            });
        },
        openUserRoles() {
            $("#roles").modal("show")
        },
        setEditingUser(user) {
            this.currentUser = user
        },
        attachRole() {
            axios.post(`user/${this.currentUser.id}/role/${this.attached_role}`).then((response) => {
                this.showSuccessMessage(response.data.data.message)
            }).catch((error) => {
                this.showFailMessage(error.response.data.data)
            }).finally(() => {
                $('#roles').modal("hide")
                this.findUser()
            })
        },
        detachRole() {
            axios.delete(`user/${this.currentUser.id}/role/${this.attached_role}`).then((response) => {
                this.showSuccessMessage(response.data.data.message)
            }).catch((error) => {
                this.showFailMessage(error.response.data.data)
            }).finally(() => {
                $('#roles').modal("hide")
                this.findUser()
            })
        }
    },
    components: { Users },
    mixins: [notificationMixin]
}
</script>
<style lang="scss" scoped>
</style>
