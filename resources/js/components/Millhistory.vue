<template>
    <div class="container-fluid">
        <div class="row justify-content-cente mt-5">
             <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h4 class="text-center">{{ Date.now() | moment(" MMMM") }} Month Mill History</h4></div>
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
                                    <p v-else class="text-success">{{singleMill.mill_status+singleMill.second_mill}}</p>
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
                userMills:[]
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
