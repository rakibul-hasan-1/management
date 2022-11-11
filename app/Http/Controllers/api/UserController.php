<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class UserController extends Controller
{
    public function index(){
        $data=User::all();
        return $data;
    }
    public function createuser(Request $request){
        if(isset($request->username)){
            $old=User::where('username',$request->username)->first();
            if(isset($old)){
                $username=$request->username.rand(0.9999);
            }else{
                $username=$request->username;
            }
        }else{
            $username="user".rand(0,9999);
        }
        if(isset($request->email)){
            $olds=User::where('email',$request->email)->first();
            if(isset($olds)){
                return response()->json([
                    'error'=>'Email Already Exist',
                ]);
            }else{
                $email=$request->email;
            }
        }else{
            return response()->json([
                'error'=>'Email required',
            ]);
        }
        if(isset($request->phone)){
            $oldss=User::where('phone',$request->phone)->first();
            if(isset($oldss)){
                return response()->json([
                    'error'=>'Phone Already Exist',
                ]);
            }else{
                $phone=$request->phone;
            }
        }else{
            return response()->json([
                'error'=>'Phone required',
            ]);
        }
        $user=new User();
        $user->name=$request->name ?? "none";
        $user->username=$username;
        $user->phone=$phone;
        $user->email=$email;
        $user->type=$request->type;
        $user->password=bcrypt($request->password);
        $user->save();
        return response()->json([
            'success'=>'Successfully User Created',
        ]);
    }
    public function getuser(Request $request){
        $data=User::find($request->id);
        return $data;
    }
    public function updateuser(Request $request){
        if(isset($request->username)){
            $old=User::where('username',$request->username)->where('id','!=',$request->id)->first();
            if(isset($old)){
                $username=$request->username.rand(0.9999);
            }else{
                $username=$request->username;
            }
        }else{
            $username="user".rand(0,9999);
        }
        if(isset($request->email)){
            $olds=User::where('email',$request->email)->where('id','!=',$request->id)->first();
            if(isset($olds)){
                return response()->json([
                    'error'=>'Email Already Exist',
                ]);
            }else{
                $email=$request->email;
            }
        }else{
            return response()->json([
                'error'=>'Email required',
            ]);
        }
        if(isset($request->phone)){
            $oldss=User::where('phone',$request->phone)->where('id','!=',$request->id)->first();
            if(isset($oldss)){
                return response()->json([
                    'error'=>'Phone Already Exist',
                ]);
            }else{
                $phone=$request->phone;
            }
        }else{
            return response()->json([
                'error'=>'Phone required',
            ]);
        }
        $user=User::find($request->id);
        $user->name=$request->name ?? "none";
        $user->username=$username;
        $user->phone=$phone;
        $user->email=$email;
        $user->type=$request->type;
        if(isset($request->password)){
            $user->password=bcrypt($request->password);
        }
        $user->save();
        return response()->json([
            'success'=>'Successfully User Created',
        ]);
    }
    public function getuserdetails(){
        return auth()->user();
    }
}
