<?php

namespace App\Http\Controllers;

use App\Models\AppToken;
use Illuminate\Http\Request;

class AppTokenController extends Controller
{
    
    public function store(Request $request)
    {
        $registerToken = $request->registerToken;
        $platform = $request->platform;
        $user_id= $request->user_id;

        $deletedRows = AppToken::where('user_id', $user_id)->delete();

        $token = new AppToken([
            'user_id' => $user_id,
            'platform' => $platform,
            'registerToken' => $registerToken
        ]);

        $token->save();

        return response()->json(
            ['respuesta' => 'Creado token de usuario']
        );
    }

    
}
