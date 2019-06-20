<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Auth;
use Hash;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return new UserResource(auth('api')->user());
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $selectUser=User::find($id);
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => "required|string|email|max:191|unique:users,id,$id",
            'phone' => "required|string|max:191|unique:users,id,$id",
            'password' => 'required|string|min:6'
        ]);

        $selectUser->name=$request->name;
        $selectUser->email=$request->email;
        $selectUser->role=$request->role;
        $selectUser->phone=$request->phone;
        $selectUser->password=Hash::make($request->password);
        if($selectUser->save()){
            return response(['message'=>'Your Profile is updated','status'=>"success"],201);
        }else{
            return response(['message'=>'Your Profile is not updated','status'=>"error"],505);
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
