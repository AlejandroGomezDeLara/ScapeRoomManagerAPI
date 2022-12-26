<?php

namespace App\Http\Controllers;

use App\Models\AppToken;
use App\PushNotifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotificationAll(Request $request)
    {
        $registerTokensAppUsers = AppToken::all();

        $msg_payload = array(
            'mtitle' => $request->mtitle,
            'mdesc' => $request->mdesc,
        );

        //Enviamos las notificaciones
        if($registerTokensAppUsers)
            $response = PushNotifications::sendNotifications($registerTokensAppUsers, $msg_payload);

        return response()->json([
            "message"=>"Notifications sent",
            "response"=>$response
        ]);
    }
}
