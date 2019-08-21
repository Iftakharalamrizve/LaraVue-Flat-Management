<template>
    <div class="container-fluid">
        <div class="row justify-content-cente mt-5">
             <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">{{ Date.now() | moment(" MMMM") }} Month Mill History</h4>
                        <div class="pull-right">
                            <button class="btn btn-info"  v-if="$gate.isAdmin()" data-toggle="modal" data-target="#addModal1">Update Mill  <i class="far fa-money-bill-alt"></i></button>
                            <button type="button" @click="reload" class="btn btn-primary" >
                                Reload
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                      <table class="table table-hover">
                        <thead >
                            <tr>
                                <th class="text-center" scope="col">Date</th>
                                <th class="text-center" scope="col" v-for=" (user,index) in users" :key="index">{{user.name}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  v-for=" (mill,index) in millList" :key="index"> 
                                <th  class="text-center" >{{mill.data[0].date}}</th>
                                <th class="text-center" v-for=" (singleMill,idx) in mill.data" :key="idx">
                                    <i v-if="(parseInt(singleMill.mill_status)+parseInt(singleMill.second_mill))==0" class="fa fa-times text-danger" aria-hidden="true"></i>
                                    <p v-else class="text-success">{{singleMill.mill_status}}+{{singleMill.second_mill}}</p>
                                </th>
                            </tr>
                            <tr> 
                                <th  class="text-center" >Total Mill :</th>
                                <th class="text-center" scope="col" v-for="(userMill,idx) in userMills" :key="idx">{{userMill}}</th>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addModal1" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Update Mill History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="updateMill" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="expense_by" id="type" v-model="form.user_id" class="form-control" >
                                <option value="">Select Member</option>
                                <option  v-for="(user,index) in users" :key="index"  :value="user.id">{{user.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" v-model="form.date" class="form-control" name="date">
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="form.mill_status" >
                                <option value="0">Off</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="form.second_mill">
                                <option value="0">Off</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                            </select>
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
        <vue-progress-bar ></vue-progress-bar>
         <vue-snotify></vue-snotify>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users:[],
                millList:[],
                date: new Date(),
                m:Number,
                userMills:[],
                form: new Form({
                    user_id:'',
                    date: '',
                    mill_status:'',
                    second_mill: '',
                }),
            }
        },
        mounted() {
            this.m = this.date.getMonth()+1;
            this.getData();
        },
        methods:{
            getData(){
                this.$Progress.start();
                axios.get("/api/mill")
                .then(response=>{
                    this.users=response.data.users.data;
                    this.millHitory();
                    console.log(this.users);
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
                
            },
            millHitory(){
                axios.get("/api/mill-history/"+this.m)
                .then(response=>{
                    
                    this.millList=response.data.millHistoryData;
                    this.userMills=response.data.userMill;
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
            },
            updateMill() {
                this.$Progress.start();
                this.form.busy = true;
                this.form.post('api/updateMill')
                .then(response=>{
                    this.getData();
                    $('#addModal1').modal('hide');
                    this.form.reset();
                    this.form.clear();
                    this.$Progress.finish();
                    this.$snotify.success("Mill Update Successfully Saved", "Success");
                })
                .catch(e=>{
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
                this.getData();
                this.$snotify.success("Data succesfully Refresh","Success");
            },
        }
    }
</script>











<style>

/* The check */
.check {
    display: block;
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    padding-right: 15px;
    cursor: pointer;
    font-size: 18px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.check input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 3px;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #fff ;
    border-color:#f8204f;
    border-style:solid;
    border-width:2px;
}



/* When the checkbox is checked, add a blue background */
.check input:checked ~ .checkmark {
    background-color: #fff  ;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.check input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.check .checkmark:after {
    left: 5px;
    top: 1px;
    width: 5px;
    height: 10px;
    border: solid ;
    border-color:#f8204f;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

</style>
