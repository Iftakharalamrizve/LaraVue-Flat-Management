<template>
    <div class="container">
        <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                <h3 class="card-title">Users Table</h3>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <select v-model="queryFiled" class="form-control" id="fileds">
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="role">Role</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input v-model="query" type="text" class="form-control"  placeholder="Search">
                        </div>
                    </div>
                <div class="card-tools">
                    <button class="btn btn-info" data-toggle="modal" data-target="#addModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                    <button type="button" class="btn btn-primary" @click="reload">
                        Reload
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 198.6px;">
                                User Profile 
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 198.6px;">
                                User Name 
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 256.2px;">
                                User Role
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 227.4px;">
                                User Phone
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 169.8px;">
                                User Email
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 120.4px;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user,index) in users" :key="index" role="row" class="odd">
                            <td class="sorting_1">{{user.profile}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.role==1?'Admin':'User'}}</td>
                            <td>{{user.phone}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <a href="#" >
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                /
                                <a href="#">
                                    <i class="fa fa-trash red"></i>
                                </a>

                            </td>
                        </tr>
                    </tbody>
              </table>
              <pagination
                    v-if="pagination.last_page > 1"
                    :pagination="pagination"
                    :offset="5"
                    @paginate="query === ''? getData() : serachData()"
                ></pagination>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">User Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createUser" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name"
                                placeholder="Name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.phone" type="number" name="phone"
                                placeholder="Phone Address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email"
                                placeholder="Email Address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <select name="type" v-model="form.role" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">Select User Role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <vue-progress-bar v-if="$gate.isAdmin()"></vue-progress-bar>
         <vue-snotify v-if="$gate.isAdmin()"></vue-snotify>
         <not-found v-if="!$gate.isAdmin()"></not-found>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users:[],
                query:'',
                queryFiled:'name',
                pagination: {
                    current_page: 1
                },
                form: new Form({
                    name: '',
                    password:'',
                    email: '',
                    role: '',
                    phone: '',
                }),
            }
        },
        mounted(){
            this.getData();
        },
        watch:{
            query:function( newQ,oldQ){
                if(newQ === ""){
                    this.getData();
                }else{
                   this.serachData();
                }
            }
        },
        methods: {
            
            getData(){
                this.$Progress.start();
                if(this.$gate.isAdmin()){
                    axios.get("/api/user?page=" + this.pagination.current_page)
                    .then(response=>{
                        this.users=response.data.data;
                        this.pagination = response.data.meta;
                        this.$Progress.finish();
                    })
                    .catch(e=>{
                    this.$Progress.fail();
                    })
                }else{
                    this.$Progress.fail();
                }
                
            },
            serachData(){
                this.$Progress.start();
                axios
                .get(
                    "/api/search/user/"+
                    this.queryFiled+
                    '/'+
                    this.query+
                    "?page="+
                    this.pagination.current_page
                )
                .then(
                    response=>{
                        this.users=response.data.data;
                        this.pagination = response.data.meta;
                        this.$Progress.finish();
                    }
                )
                .catch(e=>{
                    console.log(e);
                    this.$Progress.fail();
                })
            },
            createUser () {
            this.$Progress.start();
            this.form.busy = true;
            this.form.post('api/user')
            .then(response=>{
                this.getData();
                $('#addModal').modal('hide');
                this.form.reset();
                this.form.clear();
                this.$Progress.finish();
                this.$snotify.success("Customer Successfully Saved", "Success");
            })
            .then(e=>{
                if(e != undefined){
                    this.$Progress.fail();
                    this.$snotify.error(
                    "Something went wrong try again later.",
                    "Error"
                    );
                }
                
            })
            },
            reload(){
                this.query='';
                this.queryFiled='name';
                this.pagination.current_page=1;
                this.getData();
                this.$snotify.success("Data succesfully Refresh","Success");
            },
            
        },
    }
</script>
