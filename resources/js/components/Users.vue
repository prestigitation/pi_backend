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

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                    <i class="fa fa-plus-square"></i>
                    Добавить
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                <thead>
                    <tr>
                        <slot name="table_header">
                            <th>ID</th>
                            <slot name="table_additional_headers" />
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Роли</th>
                            <th>Email</th>
                            <th>Cоздан</th>
                            <th>Действия</th>
                        </slot>
                    </tr>
                </thead>
                <tbody>
                    <slot name="table_body">
                        <tr v-for="user in users.data" :key="user.id">

                            <td>{{user.id}}</td>
                            <slot name="table_additional_contents" />
                            <td class="text-capitalize">{{user.surname}}</td>
                            <td class="text-capitalize">{{user.name}}</td>
                            <td class="text-capitalize">{{user.patronymic}}</td>
                            <td class="text-capitalize">
                                <span class="badge badge-primary mx-1" v-for="role in user.roles" :key="role.id">
                                    {{role.name}}
                                </span>
                            </td>
                            <td>{{user.email}}</td>
                            <td>{{user.created_at}}</td>
                            <td @click.prevent="setCurrentRow">
                                <slot name="table_actions">
                                    <a href="#" @click="editModal(user)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id)">
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
    export default {
    components: { UserModal },
        data () {
            return {
                editmode: false,
                users : {},
                form: new Form({
                    id : '',
                    type : '',
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
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {

                            // Send request to the server
                            if (result.value) {
                                    this.form.delete(`${this.$props.entity}/`+id).then(()=>{
                                            Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                            );
                                        // Fire.$emit('AfterCreate');
                                        this.loadUsers();
                                    }).catch((data)=> {
                                    Swal.fire("Failed!", data.message, "warning");
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
                setCurrentRow(e) {
                        // нахождение текущего пользователя по строке, на которой был совершен клик
                        let id = e?.target?.parentElement?.parentElement?.parentElement?.childNodes[0]?.innerText
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
        },
        computed: {
            entity_title() {
                return this.$props.entity.charAt(0).toUpperCase() + this.$props.entity.slice(1);
            }
        }
    }
</script>
