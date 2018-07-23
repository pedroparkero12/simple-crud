<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddUserRequest;
use Validator;

//models
use App\User;

class UserController extends Controller
{
   
    public function index(Request $request)
    {
        // if($request->no_parent)
        // return Comment::
        // where('parent_id','=',null)
        // ->get();
        // else return Comment::where('parent_id','!=',null)->orderBy('created_at','ASC')->get()->groupBy('parent_id');
        return 'hello';
    }
    public function store(AddCommentRequest $request)
    {
        // $input = $request->all();
        // return Comment::create($input);
    }
}
