<?php
function sendNotif($notif)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $api_key = "AIzaSyBGUQoFafd7LbJ3y9XEfwrsa3aVduAsGJ0";
    $fields = array(
        'to' => '/topics/all',
        'data' => $notif
    );
    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
}

function sendCommonNotif()
{
    $notif = array("title" => "Pengumuman", "message" => "Anda mendapatkan pengumuman baru");
    sendNotif($notif);
}

//
//$notif = array("title"=>"Pengiriman Baru", "content"=>"Anda mendapatkan paket untuk dikirm");
//$id = "cx30J8NIdk4:APA91bFZXdXV7erBnMtcKAbQfA0M9o5SAJf5TAM6Y3QQi36JR_qPURjbwGZcCiqOju-8_z6erCDzrl0EMSw_mLaXVtiC41y2JLKTnNBfdFc9EOKDgQO7hcEv2ukDpY9c9BX4Mx1NyW7n";
//sendNotif($notif, $id);
?>