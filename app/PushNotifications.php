<?php
// Server file
namespace App;

class PushNotifications {

    // (Android)API access key from Google API's Console.
    private static $API_ACCESS_KEY = 'AAAAnv8TYEQ:APA91bHK83rkSdoGXJOY53AF08YVzY563lQRoQNbMFnMCDaNmF0vo6jtkpLkp4Tjl1OhEjbW9YTCXy6vpeCr8wZ86sq3vkfCZSjo7PpRFQOCA062AMS4zhjdc_TW1rthY_KDMcm443kq';
    // (iOS) Private key's passphrase.
    private static $passphrase = 'joashp';
    // (Windows Phone 8) The name of our push channel.
    private static $channelName = "joashp";

    // Change the above three vriables as per your app.

    public function __construct() {
        exit('Init function is not allowed');
    }


    public static function sendNotifications($users,$msg_payload){
        $response="Notifications send";

        foreach($users as $user) {
            if($user->platform == 'android') {
                $response=self::android($msg_payload, $user->registerToken);
            }
            else {
                $response=self::iOS_Firebase($msg_payload, $user->registerToken);
            }
        }
        return $response;
    }


    // Sends Push notification for Android users
    public static function android($data, $reg_id) {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $message = array(
            'title' => $data['mtitle'],
            'message' => $data['mdesc'],
            'image'=>$data['mimage'],
            'apiData'=>$data['data']
        );

        $headers = array(
            'Authorization: key=' .self::$API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        // campos que se van a enviar a FCM
        $fields = array(
            'registration_ids' => array($reg_id),
            'data' => $message,
            'priority'=>'high'
        );

        return self::useCurl($url, $headers, json_encode($fields));
    }

    // Sends Push notification for iOS Firebase users
    public static function iOS_Firebase($data, $reg_id) {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $message = array(
            'title' => $data['mtitle'],
            'body' => $data['mdesc'],
            //'apiData' => $data['data'],
            'sound' => 'default'
        );

        $headers = array(
            'Authorization: key=' .self::$API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        // campos que se van a enviar a FCM (distinto formato respecto a Android)
        $fields = array(
            'registration_ids' => array($reg_id),
            'notification' => $message,
            'data' => array('prueba' => '123456'),
            'priority' => 'high'
        );

        return self::useCurl($url, $headers, json_encode($fields, JSON_UNESCAPED_UNICODE));
    }

    // Sends Push's toast notification for Windows Phone 8 users
    public function WP($data, $uri) {
        $delay = 2;
        $msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
            "<wp:Notification xmlns:wp=\"WPNotification\">" .
            "<wp:Toast>" .
            "<wp:Text1>".htmlspecialchars($data['mtitle'])."</wp:Text1>" .
            "<wp:Text2>".htmlspecialchars($data['mdesc'])."</wp:Text2>" .
            "</wp:Toast>" .
            "</wp:Notification>";

        $sendedheaders =  array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $response = $this->useCurl($uri, $sendedheaders, $msg);

        $result = array();
        foreach(explode("\n", $response) as $line) {
            $tab = explode(":", $line, 2);
            if (count($tab) == 2)
                $result[$tab[0]] = trim($tab[1]);
        }

        return $result;
    }

    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {

        $deviceToken = $devicetoken;

        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);

        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;

    }

    // Curl
    private static function useCurl($url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();

        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            return $result;
        }
    }

}
