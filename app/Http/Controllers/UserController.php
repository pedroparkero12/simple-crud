<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

//models
use App\User;

class UserController extends Controller
{
    //get all users
    public function index(Request $request)
    {
        return User::get();
    }
    //input new user
    public function store(Request $request)
    {
        $input = $request->all();

        //validation
        $rules = array( 
            'firstname'         => 'required|unique:users,firstname,NULL,id,lastname,'.$input['lastname'],
            'lastname'          => 'required|unique:users,lastname,NULL,id,firstname,'.$input['firstname'],
            'username'          => 'required|unique:users,username,NULL,deleted_at,deleted_at,NULL',
        );
        
        $validator = Validator::make($input,$rules);

        $mssg  = [];
        $mssg['messages'] = [];
        
        if ($validator->fails()) {
            $response['errors']=$validator->errors();
        }
        else{
           $response = User::create($input);
           
        }

        return $response;

    }

    //edit user
    public function update(Request $request,$id)
    {
        if($id!=null){
            $input = $request->all();

            $rules = array( 
                'firstname'         => 'required|unique:users,firstname,'.$id.',id,lastname,'.$input['lastname'],
                'lastname'          => 'required|unique:users,lastname,'.$id.',id,firstname,'.$input['firstname'],
                'username'          => 'required|unique:users,username,'.$id.',id,deleted_at,NULL',
            );  
        
            $validator = Validator::make($input,$rules);
    
            $mssg  = [];
            $mssg['messages'] = [];
            
            if ($validator->fails()) {
                $response['errors']=$validator->errors();
            }
            else{
                $users = User::find($id);
                $users->firstname = $input['firstname'];
                $users->lastname = $input['lastname'];
                $users->username = $input['username'];
                $users->save();
                $response = '';
            }
            return $response;
    
        }
    }
    //delete user
    public function destroy($id){
        $users = User::find($id);
        $users->delete();

    }

}
