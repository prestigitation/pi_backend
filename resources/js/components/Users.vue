<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">

        <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                    <h3 class="card-title">
                        <slot name="table_title">
                            Список <slot name="entity_title">пользователей</slot>
                        </slot>
                    </h3>

                <div class="card-tools">
                <slot name="add_button">
                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Добавить
                    </button>
                </slot>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th class="text-capitalize align-middle text-center">ID</th>
                            <slot name="table_additional_headers" />
                            <th class="text-capitalize align-middle text-center">Фамилия</th>
                            <th class="text-capitalize align-middle text-center">Имя</th>
                            <th class="text-capitalize align-middle text-center">Отчество</th>
                            <th class="text-capitalize align-middle text-center">Роли</th>
                            <th class=" align-middle text-center">Email</th>
                            <th class="text-capitalize align-middle text-center">Cоздан</th>
                            <th class="text-capitalize align-middle text-center">Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody>
                    <slot name="table_body">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="align-middle text-center">
                                <slot name="table_content_id" :user="user">
                                    {{user.id}}
                                </slot>
                            </td>

                            <slot name="table_additional_contents" :user="user" />
                            <td class="align-middle text-center">
                                <slot name="table_content_surname" :user="user">
                                    {{user.surname}}
                                </slot>
                            </td>
                            <td class="align-middle text-center">
                                <slot name="table_content_name" :user="user">
                                    {{user.name}}
                                </slot>
                            </td>
                            <td class="align-middle text-center">
                                <slot name="table_content_patronymic" :user="user">
                                    {{user.patronymic}}
                                </slot>
                            </td>
                            <td class="align-middle text-center">
                                <slot name="table_content_roles" :user="user">
                                    <roles-data :roles="user.roles"  />
                                </slot>
                            </td>
                            <td class="align-middle text-center">
                                <slot name="table_content_email" :user="user">
                                    {{user.email}}
                                </slot>
                            </td>
                            <td class="align-middle text-center">
                                <slot name="table_content_created_at" :user="user">
                                    {{user.created_at}}
                                </slot>
                            </td>
                            <td class="text-capitalize align-middle text-center" @click.prevent="setCurrentRow">
                                <slot name="table_actions">
                                    <!-- TODO: проверить, работает ли на таблице users, если нет- исправить-->
                                    <a href="#" @click="editModal(user.user)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.user_id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </slot>
                            </td>
                    </tr>
                    </slot>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="table_data ? table_data : users" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>
        <slot name="edit_modal">
            <user-modal
                @update_user="$props.update_user ? $props.update_user() : updateUser()"
                @create_user="$props.create_user ? $props.create_user() : createUser()"
                id="addNew"
                :editmode="editmode"
                :form="form"
            >
                <div slot="modal_additional_content">
                    <slot name="user_additional_content"></slot>
                </div>
            </user-modal>
        </slot>
    </div>
</section>
</template>

<script>
import UserModal from './UserModal.vue';
import { notificationMixin } from '../mixins/notificationMixin'
import RolesData from './layout/RolesData.vue';
    export default {
    components: { UserModal, RolesData },
    mixins: [notificationMixin],
        data () {
            return {
                editmode: false,
                users : {},
                form: new Form({
                    id : '',
                    name: '',
                    surname: '',
                    patronymic: '',
                    email: '',
                    password: '',
                    email_verified_at: '',
                })
            }
        },
        methods: {
                getResults(page = 1) {
                    this.$Progress.start();
                    axios.get(`${this.$props.entity}?page=` + page).then(({ data }) => (this.users = data));
                    this.$Progress.finish();
                },
                updateUser(){
                    this.$Progress.start();
                    // console.log('Editing data');
                    this.form.put(`${this.$props.entity}/`+this.form.id)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                            //  Fire.$emit('AfterCreate');

                        this.loadUsers();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

                },
                editModal(user){
                    this.editmode = true;
                    this.form.reset();
                    $('#addNew').modal('show');
                    this.form.fill(user);
                },
                newModal() {
                    if(this.$props.entity) {
                        this.$emit('openAddModal')
                    } else {
                        this.editmode = false;
                        this.form.reset();
                        $('#addNew').modal('show');
                    }
                },
                deleteUser(id){
                    Swal.fire({
                        title: 'Удаление пользователя',
                        text: "Вы действительно хотите удалить данного пользователя?",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Да'
                        }).then((result) => {

                            // Send request to the server
                            if (result.value) {
                                    this.form.delete(`${this.$props.entity}/`+id).then(()=>{
                                        this.showSuccessMessage(response.data.data.message)
                                        // Fire.$emit('AfterCreate');
                                        this.loadUsers();
                                    }).catch((error)=> {
                                    this.showFailMessage(error.response.data.data)
                                });
                            }
                        })
                },
                loadUsers() {
                    this.$Progress.start();

                    if(this.$gate.isAdmin()) {
                        if(!this.table_data) {
                            axios.get(`${this.$props.entity}`).then(({ data }) => (this.users = data));
                        } else this.users = this.table_data
                    }

                    this.$Progress.finish();

                },
                createUser(){

                this.form.post(`${this.$props.entity}`)
                    .then((response)=>{
                        $('#addNew').modal('hide');
                        Toast.fire({
                                icon: 'success',
                                title: response.data.message
                        });

                        this.$Progress.finish();
                        this.loadUsers();
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
                },
                setNewData(data) {
                    console.log(data);
                },
                setCurrentRow(e) {
                        // нахождение текущего пользователя по строке, на которой был совершен клик
                        let id = e?.target?.parentElement?.parentElement?.parentElement?.childNodes[0]?.innerText
                        console.log(e);
                        if(id && !isNaN(parseInt(id))) {
                            if(this.table_data) {
                                this.$emit('set_editing_id', this.findCurrentUser(this.table_data.data, id))
                            }
                            else if(this.users) {
                                this.$emit('set_editing_id', this.findCurrentUser(this.users.data, id))
                            }
                        }
                    },
                findCurrentUser(data, userId) {
                    return data.filter(item => item.id === parseInt(userId))[0]
                }
        },
        watch: {
            '$props.table_data': function(current, previous) {
                this.users = current
            }
        },
        props: {
            entity: {
                type: String,
                default: 'user'
            },
            table_data: {
                type: Object,
                default: () => undefined
            },
            update_user: {
                type: Function
            },
            create_user: {
                type: Function
            }
        },
        mounted() {
            this.$Progress.start();
            this.loadUsers(this.$props.entity);
            this.$Progress.finish();

            this.$on('set_new_users', function(data) {
                console.log(data);
                return this.setNewData(data)
            })
        },
        computed: {
            entity_title() {
                return this.$props.entity.charAt(0).toUpperCase() + this.$props.entity.slice(1);
            }
        }
    }
</script>
