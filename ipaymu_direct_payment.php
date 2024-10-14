<?php
    // SAMPLE HIT API iPaymu v2 PHP //
    $va = '1179000899'; //get on iPaymu dashboard
    $apiKey = 'QbGcoO0Qds9sQFDmY0MWg1Tq.xtuh1'; //get on iPaymu dashboard

    $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct'; // for development mode
    // $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; // for production mode

    // Request Body
    $body['name'] = trim("Putu Made Nyoman Ketut");
    $body['phone'] = trim("081234567890");
    $body['email'] = trim("test@example.com");
    $body['amount'] = floatval(100000);
    $body['notifyUrl'] = trim('https://your-website.com/callback-url');
    $body['referenceId'] = '1234'; //your reference id
    $body['paymentMethod'] = trim("va");
    $body['paymentChannel'] = trim("bca");
    // End Request Body//

    // Generate Signature
    // *Don't change this
    $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
    $requestBody = strtolower(hash('sha256', $jsonBody));
    $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
    $signature = hash_hmac('sha256', $stringToSign, $apiKey);
    $timestamp = Date('YmdHis');
    //End Generate Signature

    // Request header
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'va: ' . $va,
        'signature: ' . $signature,
        'timestamp: ' . $timestamp
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_POST, count($body));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $err = curl_error($ch);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($err) {
        print_r($err);
    } else {
        //Response
        print_r($response);
        // $responseDecode = json_decode($response);
        //End Response
    }

?>
