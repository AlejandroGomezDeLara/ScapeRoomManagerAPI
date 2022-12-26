<?php

namespace App\Http\Controllers;

use App\Models\AppToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppTokenController extends Controller
{
    
    public function store(Request $request)
    {
        $registerToken = $request->registerToken;
        $platform = $request->platform;

        $deletedRows = AppToken::where('user_id', Auth::id())->delete();

        $token = new AppToken([
            'user_id' => Auth::id(),
            'platform' => $platform,
            'registerToken' => $registerToken
        ]);

        $token->save();

        return response()->json(
            ['respuesta' => 'Creado token de usuario']
        );
    }

    
}
