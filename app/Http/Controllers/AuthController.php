<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegesterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegesterRequest $request )
    {
        $validated=$request->validated();
        $imageName = time().'.'.$request->image->extension();
        $path=$request->image->move(public_path('UserImages'), $imageName);




        $user=User::create($request->safe()->except('image'));
        $user->image=$path;
        $user->save();


        $token=$user->createToken('auth_token')->plainTextToken;
        return response(['message'=>'The User Registered Successfully','code'=>200]);
    }

    public function login(Request $request)
    {
        $user=User::where('phone_number',$request->phone_number)->first();
        if(!$user){
            response(['message'=>'The Phone Number Incorrect','code'=>404]);
        }
        if (! Auth::attempt(['phone_number'=>$request->phone_number,'password'=>$request->password]))
        {
            return response(['message'=>'Password Incorrect','code'=>404]);
        }
       $token= $user->createToken('auth_token')->plainTextToken;
        return response(['token'=>$token,'message'=>'The User Logged in Successfully','code'=>200]);
    }
    public function logout(){
       $user=Auth::user();
       $token=$user->tokens()->delete();
        return response(['token'=>$token,'message'=>'The User Logged out Successfully','code'=>200]);

    }
}
