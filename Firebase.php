<?php
    require_once "koneksi.php";
    if(function_exists($_GET['function'])) {
        $_GET['function']();
    }
    function sendPushNotification() {  
        global $connect;
        $fcm_token = $_POST['fcm_token'];
        $title = $_POST['title'];
        $message = $_POST['message'];

        $url = "https://fcm.googleapis.com/fcm/send";            
        $header = [
            'authorization: key=AAAA4dDBTcw:APA91bEGGQ-h1ogBdYxWjfEVzQ39iRhclvFWxUUpwpLCMuA-HmCQA0W69fDUIy3AGi3Ap1JqJ7r0OutAH6u3fGoRKZDe64rzYpOXSBOzmVGPLNFmidmv5I-nnJa4HiHdwFDEDo3m4Qjc',
            'content-type: application/json'
        ];    
     
        $notification = array(
            'title' =>$title,
            'body' => $message
        );
        // $extraNotificationData = ["message" => $notification];
     
        // $fcmNotification = [
        //     'to'        => '/topics/' . $fcm_token,
        //     'notification' => $notification,
        //     'data' => $extraNotificationData
        // ];
        $fcmNotification = [
            'registration_ids' =>  [$fcm_token],
            'notification' => $notification
        ];
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     
        $result = curl_exec($ch);
        if ($result === FALSE) {
            $response = array(
                'status' => 1,
                'message' => "success to send notification"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            die('FCM Send Error: ' . curl_error($ch));
        }
        else if($result === TRUE){
            $response = array(
                'status' => 1,
                'message' => "success to send notification"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        curl_close($ch);
        $response = array(
            'token' => $fcm_token,
            'title' => $title,
            'message' => $message,
            'result' => $result
        );
        header('Content-Type: application/json');
        echo $result;
        return $result;
    }

?>