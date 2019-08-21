<template>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <label for="">Select Month :</label>
            {{date.month}}
            <month-picker @change="showDate"></month-picker>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                date: {
                    month: null,
                    year: null
                },
                month:Number,
                year:'',
                monthList:['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            }
        },
        mounted() {
        },
        methods:{
            showDate (date) {
                this.date = date
            }
        }
    }
</script>
<style>

</style>
