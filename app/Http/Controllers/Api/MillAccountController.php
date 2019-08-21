<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MillAccounts;
use Auth;
use DB;
use App\User;
class MillAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $data= DB::table('mill_accounts')
        ->join('users','mill_accounts.user_id','=','users.id')
        ->select('mill_accounts.*','users.name')
        ->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'expense_type' => 'required',
            'expense_item_type' => 'required_if:expense_type,1',
            'expense_amount' => 'required',
            'expense_by' => 'required'
        ]);
        return MillAccounts::create([
            'user_id' => $request->expense_type,
            'expense_type' => $request->expense_type,
            'expense_item_type' => $request->expense_item_type,
            'expense_amount' => $request->expense_amount,
            'status' =>0,
            'note' =>$request->note,
        ]);
    }

    public function cangeStatus($id){
        $objectModel=MillAccounts::find($id);
        if($objectModel->status==0){
            $objectModel->status=1;
        }else{
            $objectModel->status=0;
        }
        if($objectModel->save()){
            return response(['message'=>'Your Status  is updated','status'=>"success"],201);
        }else{
            return response(['message'=>'Your Status is not updated','status'=>"error"],505);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($month)
    {
        //month convert 1-9 to 01-09 for filter data 
        if($month<10){
            $month = '0'.$month;
        }
        //date make 
        $date= date('Y') . "-" .$month;
        $data= DB::table('mill_accounts')->join('users','mill_accounts.user_id','=','users.id')
                ->where('mill_accounts.created_at','LIKE',"%$date%")
                ->select('mill_accounts.*','users.name')
                ->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $selectAccount=MillAccounts::find($id);
        $this->validate($request,[
            'expense_type' => 'required',
            'expense_item_type' => 'required',
            'expense_amount' => 'required'
        ]);
        $selectAccount->user_id = 1;
        $selectAccount->expense_type = $request->expense_type;
        $selectAccount->expense_item_type = $request->expense_item_type;
        $selectAccount->expense_amount = $request->expense_amount;
        $selectAccount->status =0;
        $selectAccount->note =$request->note;
        if($selectAccount->save()){
            return response(['message'=>'Your BIll is updated','status'=>"success"],201);
        }else{
            return response(['message'=>'Your Bill is not updated','status'=>"error"],505);
        }
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




    public function findDeposite($id,$month){
       $date= date('Y') . "-" .$month;
       $data['deposite_amount']= User::find($id)->bills()
              ->whereMonth('created_at', '=', date($month))
              ->where('expense_type',2)
              ->where('status',1)
              ->sum('expense_amount');
        $dayMill=User::find($id)->mills()
              ->whereMonth('date', '=', date($month))
              ->sum('mill_status');
        $nightMill=User::find($id)->mills()
              ->whereMonth('date', '=', date($month))
              ->sum('mill_status2');
        $data['total_mill']=$dayMill+$nightMill;
        return $data;
    }
}
