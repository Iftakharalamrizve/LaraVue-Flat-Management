<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MillAccounts;
use Auth;
use App\User;
class MillAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $data= MillAccounts::all();
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
            'expense_amount' => 'required'
        ]);

        return MillAccounts::create([
            'user_id' => 1,
            'expense_type' => $request->expense_type,
            'expense_item_type' => $request->expense_item_type,
            'expense_amount' => $request->expense_amount,
            'status' =>0,
            'note' =>$request->note,
        ]);
    }

    public function cangeStatus($id){
        $objectModel=MillAccounts::find($id);
        $objectModel->status==0?$objectModel->status=1?$objectModel->status==1:$objectModel->status=0:'';
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
}
