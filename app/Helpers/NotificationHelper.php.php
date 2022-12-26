<?php

use App\AppTokens;
use App\Models\AppToken;
use App\NotificationsDenied;
use App\PushNotifications;
use App\NotificationUser;
use Illuminate\Support\Facades\Log;

/**
 * Class NotificationHelper
 *
 * Este helper envía notificaciones al front para mostrarlo en un mensaje
 * emergente.
 */
class NotificationHelper
{

    /**
     * Almacena las notificaciones recibidas y además las envía por push
     * a los dispositivos móviles.
     *
     * @param        $user_ids
     * @param        $message
     * @param string $subject
     */
    public static function storeAndSendPushNotifications(
        $user_ids,
        $message,
        $subject = '',
    ) {

      
        //Guardamos las not


        $users = AppToken::whereIn('id_usuario', $user_ids)->get();
        
        ## Envía las notificaciones a los dispositivos móviles.
        $msg_payload = array(
            'mtitle' => $message,
            'mdesc' => $subject,
        );

        try {
            PushNotifications::sendNotifications($users, $msg_payload);
        } catch (Exception $e) {
            Log::error('Error al enviar notificaciones push en NotificationHelper función storeAndSendPushNotifications()');
            Log::error($e);
        }
    }
}
