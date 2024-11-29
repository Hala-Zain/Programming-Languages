<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use function Symfony\Component\String\u;

class UserController extends Controller
{
    public function getProfile($id){
       $user= User::find($id);
       if (!$user){
           return response(['message'=>'User Not Found'],404);

       }
        return response(['user'=>UserResource::make($user)],200);

    }
    public function updateProfile(UserRequest $request,$id){
        $user=User::find($id);
        if (!$user){
            return response(['message'=>'User Not Found'],404);
        }
        if ($request->image)
        {
            if ($user->image && File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $imageName= time().'.'.$request->image->extension();
            $request->image->move(public_path('UserImages'), $imageName);

            $user->update(['image'=>'UserImages/' . $imageName]);
            $user->save();
        }
        $user->update($request->safe()->except('image'));

        return response(['user'=>UserResource::make($user)],200);
    }
}
