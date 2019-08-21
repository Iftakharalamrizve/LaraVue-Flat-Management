<template>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <select v-model="userFidnId" class="form-control" id="fileds" @change="userHistoryChange($event)">
                    <option  v-for="(user,index) in users" :key="index"  :value="user.id">{{user.name}}</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 offset-md-3">
                <div class="tile">
                    <div class="wrapper">
                        <div class="header">Event Title</div>

                        <div class="banner-img">
                            <img src="http://via.placeholder.com/640x360" alt="Image 1">
                        </div>

                        <div class="dates">
                            <div class="start">
                                <strong>STARTS</strong> 1-{{ Date.now() | moment(" MMM-Y") }}
                                <span></span>
                            </div>
                            <div class="ends">
                                <strong>ENDS</strong> {{ Date.now() | moment(" D-MMM-Y") }}
                            </div>
                        </div>

                        <div class="stats">

                            <div>
                                <strong>Total Deposite</strong> {{totalDiposite}}
                            </div>

                            <div>
                                <strong>Total Mill</strong> {{totalUserMill}}
                            </div>

                            <div>
                                <strong>Total Expense</strong> {{parseFloat(costAmount/totalMill).toFixed(2)*totalUserMill}}
                            </div>

                        </div>

                        <div class="stats">

                            <div>
                                <strong>Mill Rate </strong> {{parseFloat(costAmount/totalMill).toFixed(2)}}
                            </div>

                            <div>
                                <strong>Due/Pay</strong> {{parseFloat(totalDiposite-(parseFloat(costAmount/totalMill).toFixed(2)*totalUserMill)).toFixed(2)}}
                            </div>

                            <div>
                                <strong>DECLINED</strong> 182
                            </div>

                        </div>

                        <div class="stats">

                            <div>
                                <strong>INVITED</strong> 3098
                            </div>

                            <div>
                                <strong>JOINED</strong> 562
                            </div>

                            <div>
                                <strong>DECLINED</strong> 182
                            </div>

                        </div>

                        <div class="footer">
                            
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <vue-progress-bar ></vue-progress-bar>
         <vue-snotify></vue-snotify>
         <not-found v-if="!$gate.isAdmin()"></not-found>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                userFidnId:Number,
                bills:[],
                marketList:[],
                users:[],
                date: new Date(),
                month:Number,
                totalMill:0,
                costAmount:0,
                totalUserMill:0,
                totalDiposite:0
            }
        },
        mounted() {
            this.month = this.date.getMonth()+1;
            this.getData();
            this.getExpense();
            this.userFidnId=this.$gate.currentUserIdReturn();;
            this.userHistoryChange(this.userFidnId);
        },
        methods:{
             getData(){
                this.$Progress.start();
                axios.get("/api/users")
                .then(response=>{
                    console.log(response);
                    this.users=response.data.data;
                    this.$Progress.finish();
                })
                .catch(e=>{
                    this.$Progress.fail();
                })
                
            },
             getExpense(){
                this.$Progress.start();
                var self=this;
                axios.get('/api/millexpense/'+this.month)
                .then(response=>{
                    self.bills=response.data;
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
                self.costAmount=0;
                this.bills.forEach((item)=>{
                    if(item.expense_item_type != null){
                        // self.marketList.push(item);
                        if(item.status==1){
                            self.costAmount += item.expense_amount;
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

            userHistoryChange(event=null){
                //total diposite balance
                const id = event.target == undefined ?event:event.target.value;
                let self = this;
                this.$Progress.start();
                axios.get("/api/diposite_user/"+id+'/'+this.month)
                .then(response=>{
                    self.totalUserMill=response.data.total_mill;
                    self.totalDiposite=response.data.deposite_amount;
                })
                .catch(e=>{

                })


                //total mill history 


                
            }

            
        }
    }
</script>
<style>
* { margin: 0px; padding: 0px; }
body {
	background: #ecf1f5;
	font:14px "Open Sans", sans-serif; 
	text-align:center;
}

.tile{
	width: 100%;
	background:#fff;
	border-radius:5px;
	box-shadow:0px 2px 3px -1px rgba(151, 171, 187, 0.7);
	float:left;
  	transform-style: preserve-3d;
  	margin: 10px 5px;

}

.header{
	border-bottom:1px solid #ebeff2;
	padding:19px 0;
	text-align:center;
	color:#59687f;
	font-size:600;
	font-size:19px;	
	position:relative;
}

.banner-img {
	padding: 5px 5px 0;
}

.banner-img img {
	width: 100%;
	border-radius: 5px;
}

.dates{
	border:1px solid #ebeff2;
	border-radius:5px;
	padding:20px 0px;
	margin:10px 20px;
	font-size:16px;
	color:#5aadef;
	font-weight:600;	
	overflow:auto;
}
.dates div{
	float:left;
	width:50%;
	text-align:center;
	position:relative;
}
.dates strong,
.stats strong{
	display:block;
	color:#adb8c2;
	font-size:11px;
    font-weight:700;
    color: #172a3c;
}
.dates span{
	width:1px;
	height:40px;
	position:absolute;
	right:0;
	top:0;	
	background:#ebeff2;
}
.stats{
	border-top:1px solid #ebeff2;
	background:#f7f8fa;
	overflow:auto;
	padding:15px 0;
	font-size:16px;
	color:#59687f;
	font-weight:600;
	border-radius: 0 0 5px 5px;
}
.stats div{
	border-right:1px solid #ebeff2;
	width: 33.33333%;
	float:left;
    text-align:center;
    color: black;
}

.stats div:nth-of-type(3){border:none;}

div.footer {
	text-align: right;
	position: relative;
	margin: 20px 5px;
}

div.footer a.Cbtn{
	padding: 10px 25px;
	background-color: #DADADA;
	color: #666;
	margin: 10px 2px;
	text-transform: uppercase;
	font-weight: bold;
	text-decoration: none;
	border-radius: 3px;
}

div.footer a.Cbtn-primary{
	background-color: #5AADF2;
	color: #FFF;
}

div.footer a.Cbtn-primary:hover{
	background-color: #7dbef5;
}

div.footer a.Cbtn-danger{
	background-color: #fc5a5a;
	color: #FFF;
}

div.footer a.Cbtn-danger:hover{
	background-color: #fd7676;
}
</style>
