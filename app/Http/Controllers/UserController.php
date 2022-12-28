<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update($user_id, Request $request)
    {

        $user = $request->user();
        $request->request->remove('avatar');  
        if ($request->get('upload_image') != null) {
            $img=$request->get('upload_image');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace('data:image/jpg;base64,', '', $img);

            $img = str_replace(' ', '+', $img);
            $img=base64_decode($img);
            $imageName =date('mdYHis') . uniqid() .'.png';
            Storage::disk('public')->put('users/'.$imageName, $img);
            $path="users/".$imageName;
            $request->merge(['avatar'=>$path]);  
        }

        if ($request->password != '') {
            $request->password = bcrypt($request->password);
            $user->password = $request->password;
            $user->save();
        }
        $user->update($request->all());

        return $user;
    }

    public function show($user_id)
    {
        return User::find($user_id);
    }
}
