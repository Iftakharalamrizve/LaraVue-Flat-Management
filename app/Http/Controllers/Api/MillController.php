<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\MillCollection;
use Illuminate\Support\Facades\Input;
use File;
use DB;
use App\User;
use App\MillHistory;
class MillController extends Controller
{
    public function __construct(){
        date_default_timezone_set("Asia/Dhaka");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users']= new UserCollection(User::orderBy('id', 'ASC')->get());
        $previousStatus=$this->checkPrevioustDate();
        if($previousStatus){
            $data['existingCurrentdata']=new MillCollection(DB::table('users')
                ->leftjoin('mill_histories','users.id','=','mill_histories.user_id')
                ->where('date',date("Y-m-d"))
                ->get());
        }
        
        return $data;
    }
    // %'.date("Y").'-'.$month.'%
   
    
    public function millHistoryByMonth($month)
    { 
        //month convert 1-9 to 01-09 for filter data 
        if($month<10){
            $month = '0'.$month;
        }
        //date make 
        for($i = 1; $i<=date("d"); $i++)
        {   
            $dates[] = date('Y') . "-" .$month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        //get total mill
        //user wise mill count liske user 1 =30 mill
        $users= new UserCollection(User::orderBy('id', 'ASC')->get());
        $userMill=[];
        foreach($users as $user){
            $total_mill=0;
            foreach($dates as $date){
                $status=MillHistory::where('user_id',$user->id)->where('date','LIKE',"%$date%")->select('mill_status','mill_status2')->first();
                $everyDayMill=$status["mill_status"]+$status["mill_status2"];
                $total_mill +=$everyDayMill;
            }
            $userMill[$user->id]=$total_mill;
        }
        
        //total mill history 
        $millHistoryData=[];
        foreach($dates as $date){
            $millHistoryData[]=new MillCollection(MillHistory::orderBy('user_id', 'ASC')->where('date','LIKE',"%$date%")->get());
        }
        
        $data['millHistoryData']=$millHistoryData;
        $data['userMill']=$userMill;
        return $data;
        
    }

    public function TotalUserMill($month){
        //month convert 1-9 to 01-09 for filter data 
        if($month<10){
            $month = '0'.$month;
        }
        //date make 
        for($i = 1; $i<=date("d"); $i++)
        {   
            $dates[] = date('Y') . "-" .$month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        //user wise mill count liske user 1 =30 mill
        $users= new UserCollection(User::orderBy('id', 'ASC')->get());
        $userMill=[];
        foreach($users as $user){
            $total_mill=0;
            foreach($dates as $date){
                $status=MillHistory::where('user_id',$user->id)->where('date','LIKE',"%$date%")->select('mill_status','mill_status2')->first();
                $everyDayMill=$status["mill_status"]+$status["mill_status2"];
                $total_mill +=$everyDayMill;
            }
            $userMill[$user->id]=$total_mill;
        }

        return array_sum($userMill);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        MillHistory::create(['user_id' => $request->user_id,'date'=>$request->date,'mill_status'=>$request->mill_status,'mill_status2'=>$request->second_mill]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $date)
    {
        $updateMill=MillHistory::where('user_id',$request->user_id)->where('date',$date)->first();
        $updateMill->mill_status=$request->mill_status;
        $updateMill->mill_status2=$request->second_mill;
        $updateMill->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //extra 

    public function checkPrevioustDate(){
        
        for($i = 1; $i<=date("d"); $i++)
        {
            // add the date to the dates array
            $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        $users=new UserCollection(User::orderBy('id', 'DESC')->get());
        $count=$users->count();
        foreach($dates as $date){
            $checkDate=MillHistory::where('date',$date)->first();
            $countNumber=(array)$checkDate;
            if(count($countNumber)<1){
                for($i=0;$i<$count;$i++){
                    MillHistory::create(['user_id' => $users[$i]->id,'date'=>$date,'mill_status'=>0,'mill_status2'=>0]);
                }
            }
        }

        return true;
    }
}
