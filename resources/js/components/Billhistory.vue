<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h4 class="text-center">{{ Date.now() | moment("dddd, MMMM Do YYYY") }}</h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button class="btn btn-info" data-toggle="modal" data-target="#addModal">Add Bill <i class="far fa-money-bill-alt"></i></button>
                <button type="button" class="btn btn-primary" >
                    Reload
                    <i class="fa fa-refresh"></i>
                </button>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="table-responsive">
                    <table  class="table table-bordred table-striped">
                        <thead>
                            <th class="text-center" >User Name</th>
                            <th class="text-center" >Expensr Type </th>
                            <th class="text-center" >Expense Item Type </th>
                            <th class="text-center" >Expense Amount </th>
                            <th class="text-center" >Status</th>
                        </thead>
                        <tbody v-if="bills.length>0">
                            <tr class="text-center"  v-for="(billsingle,index) in allAccounts" :key="index">
                                <td>{{billsingle.name}}</td>
                                <td>{{billsingle.expense_type==1?'Market':'deposit'}}</td>
                                <td>{{billsingle.expense_item_type==1?'Kacabazaar':'Others'}}</td>
                                <td>{{billsingle.expense_amount}}</td>
                                <td v-if="$gate.isAdmin()">
                                    <button type="button" v-if="billsingle.status==0" class="btn bg-warning margin btn-sm" v-on:click="changeStatus(billsingle.id)" > Peanding </button>
                                    <button type="button" v-else class="btn bg-navy margin btn-sm" v-on:click="changeStatus(billsingle.id)" > Approved</button>
                                </td>
                                <td v-else>
                                    <span class="text-warning" v-if="billsingle.status==0">Peanding</span>
                                    <span class="text-success" v-else>Success</span>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <th colspan="8">
                                    <p class="text-danger text-center">There are No data </p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="table-responsive table-bordered movie-table">
                    <table class="table movie-table">
                        <thead>
                        <tr class= "movie-table-head">
                            <th>Accounts Type </th>
                            <th>Amount</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <!--row-->
                        <tr class= "dark-row">
                            <td >Diposite</td>
                            <td> <span style="color:green;">{{dipositAmount}}</span></td>                                     
                        </tr>
                        <!--/.row-->
                    <!--row-->
                        <tr class="light-row">
                            <td>Expense </td>
                            <td> <span style="color:green;">{{costAmount}}</span></td>                                     
                        </tr>
                         <tr class="light-row">
                            <td>Total Mill </td>
                            <td> <span style="color:green;">{{totalMill}}</span></td>                                     
                        </tr>
                        <tr class="light-row">
                            <td>Total Mill Rate : </td>
                            <td> <span style="color:green;">{{parseFloat(costAmount/totalMill).toFixed(2)}}</span></td>                                     
                        </tr>
                    </tbody>
                    </table>
                    </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Create Bill History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="crateBill" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" v-model="form.user_id">
                        <div class="form-group">
                            <select name="expense_type" v-model="form.expense_type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('expense_type') }">
                                <option value="">Expense  Type </option>
                                <option value="1">Market</option>
                                <option value="2">Diposite</option>
                            </select>
                            <has-error :form="form" field="expense_type"></has-error>
                        </div>
                        <div class="form-group" v-if="form.expense_type==1">
                            <select name="expense_item_type" v-model="form.expense_item_type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('expense_item_type') }">
                                <option value="">Expense Item Type </option>
                                <option value="1">Kaca Bazar / Sukna Bazar  </option>
                                <option value="2">Others</option>
                            </select>
                            <has-error :form="form" field="expense_item_type"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.expense_amount" type="number" name="expense_amount"
                                placeholder="Expense Amount"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('expense_amount') }">
                            <has-error :form="form" field="expense_amount"></has-error>
                        </div>
                        <div class="form-group">
                            <select name="expense_by" v-model="form.expense_by" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('expense_by') }">
                                <option value="">Select Expense By </option>
                                <option  v-for="(user,index) in allUser" :key="index"  :value="user.id">{{user.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input v-model="form.note" type="text" name="note"
                                placeholder="Note"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('note') }">
                            <has-error :form="form" field="note"></has-error>
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
         <vue-snotify ></vue-snotify>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                bills:[],
                allAccounts:[],
                marketList:[],
                dipositList:[],
                allUser:[],
                dipositAmount:0,
                costAmount:0,
                date: new Date(),
                month:Number,
                totalMill:0,
                form: new Form({
                    id:'',
                    user_id: '',
                    expense_type:'',
                    expense_item_type: '',
                    expense_amount: '',
                    expense_by:'',
                    note: '',
                }),
            }
        },
        mounted() {
            this.month = this.date.getMonth()+1;
            this.getExpense();
            this.getUsers();
        },
        methods:{

            getExpense(){
                this.$Progress.start();
                var self=this;
                axios.get('/api/millexpense/'+this.month)
                .then(response=>{
                    self.bills=response.data;
                    self.allAccounts=response.data;
                    this.getTotalMill();
                    this.getAmountMarketBill();
                    this.$Progress.finish();
                    
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
            },
            getAmountMarketBill(){
                var self=this;
                self.dipositAmount=0;
                self.costAmount=0;
                this.bills.forEach((item)=>{
                    if(item.expense_item_type != null){
                        // self.marketList.push(item);
                        if(item.status==1){
                            self.costAmount += item.expense_amount;
                        }
                    }else{
                        self.dipositList.push(item);
                        if(item.status==1){
                            self.dipositAmount += item.expense_amount;
                        }
                    }
                })
            },
            getTotalMill(){
                var self=this;
                this.$Progress.start();
                axios.get("/api/totalMill/"+this.month)
                .then(response=>{
                    self.totalMill=response.data;
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
            },
            changeStatus(index){
                var self=this;
                this.$Progress.start();
                axios.get('/api/millexpense-chagestatus/'+index)
                .then((response)=>{
                    self.getExpense();
                    this.$Progress.finish();
                    this.$snotify.success(response.data.message, "Success");
                })
                .catch(e=>{
                    this.$Progress.fail();
                    this.$snotify.error("Your Status Not Update", "Success");
                })
            },
            crateBill() {
                this.$Progress.start();
                this.form.busy = true;
                this.form.post('api/millexpense')
                .then(response=>{
                    this.getExpense();
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
            
            millHitory(){
                this.$Progress.start();
                axios.get("/api/mill-history/"+this.month)
                .then(response=>{
                    this.userMills=response.data.userMill;
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
            },

            getUsers(){
                this.$Progress.start();
                axios.get("/api/users")
                .then(response=>{
                    this.allUser=response.data.data;
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
            }
        }
    }
</script>
<style>
.dark-row{
    background:#AEC5E8;
    
}
.light-row{
    
    background:#F1F3F0;
}
.bg-navy {
    background-color: #001f3f !important;
    color: whitesmoke;
}
.bg-navy:hover{
    color: white;
}
</style>
