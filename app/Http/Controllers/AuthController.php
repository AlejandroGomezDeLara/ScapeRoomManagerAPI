<?php

namespace App\Http\Controllers;

use App\Models\User as User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function signup(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'years' => $request->years,
            'weight' => $request->weight,
            'height' => $request->height
        ]);




        if ($request->get('avatar') != null) {
            $img = $request->get('avatar');
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);
            $imageName = date('mdYHis') . uniqid() . '.jpeg';
            Storage::disk('public')->put('users/' . $imageName, $img);
            $path = "users/" . $imageName;
            $user->avatar = $path;
        }

        $user->save();

        $this->setGoalsAndInterests($request->goals, $request->interests, $request->training_days, $user);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

   



    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        $user->api_token = $tokenResult->accessToken;

        return response()->json($user);
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();

        return response()->json(['message' =>
        'Successfully logged out']);
    }

}
