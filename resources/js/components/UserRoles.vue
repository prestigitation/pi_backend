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
        <div v-if="foundUsers.length">
            <Users></Users>
        </div>
    </div>
</section>
</template>
<script>
import axios from "axios"
import Users from "./Users.vue"

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
            roles: [],
            foundUsers: [],
        };
    },
    created() {
        axios.get("role").then(({ data }) => {
            this.roles = data;
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
                this.foundUsers = data;
            });
        }
    },
    components: { Users }
}
</script>
<style lang="scss" scoped>
</style>
