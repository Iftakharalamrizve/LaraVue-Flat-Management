<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Today Mill  <h4 class="text-center">{{ Date.now() | moment("dddd, MMMM , YYYY") }}</h4></div>
                    <div class="card-body table-responsive">
                      <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" v-for=" (user,index) in users" :key="index">{{user.name}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td v-for=" (mill,index) in millCurrent" :key="index">
                                    <label class="check ">
                                        <input type="checkbox"  :checked='mill.mill_status'  @click="check(index)" name="is_name">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-cente mt-5">
            
             <mill-history ></mill-history>
        </div>
        <vue-progress-bar ></vue-progress-bar>
         <vue-snotify></vue-snotify>
    </div>
</template>

<script>
    export default {
        data(){
            return{

               ckDate : { myDate : new Date().toISOString().slice(0,10) },
                users:[],
                todayMillHistory:[],
                millCurrent:[],
                millHistoryStatus:false
            }
        },
        mounted() {
            this.getData();
        },
        methods:{
            getData(){
                this.$Progress.start();
                axios.get("/api/mill")
                .then(response=>{
                    this.users=response.data.users.data;
                    this.todayMillHistory=response.data.existingCurrentdata.data;
                     this.forData();
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
                
            },
            forData(){
                
                var currentDate=this.ckDate.myDate
                //first time when field is creat and save default value in table 
                if(this.todayMillHistory.length>0){
                    this.todayMillHistory.forEach(singleBill=>{
                        this.millCurrent.push(singleBill);
                    });
                }else{
                    this.users.forEach(user=>{
                        this.millCurrent.push({"mill_status":0,"date":currentDate,'user_id':user.id});
                    });
                    this.millCurrent.forEach(singleRequest=>{
                        axios.post('/api/mill',singleRequest)
                        .then(response=>{
                            
                        })
                    })
                }
            },
            check(index){
                this.millCurrent[index].mill_status=!this.millCurrent[index].mill_status;
                var updateMill=this.millCurrent[index];
                axios.put('/api/mill/'+ updateMill.date,updateMill)
                .then(response=>{
                     this.$snotify.success("Your Mill Status Is update", "Success");
                })
            }
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
