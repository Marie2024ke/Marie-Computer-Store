<?php
//YOU MPESA API KEYS
$consumerKey = "rewKsu3rtjDzN2CcevxZMlpWXdkFifLvUBF3rYOGFJdCifFV"; //Fill with your app Consumer Key
$consumerSecret = "0wd8tAEOGUZQaHBFGs0juiiHiNpGUr3dPOgU8NpY0h5HYTpaGHmfdMT30Ae1gvAm"; //Fill with your app Consumer Secret
//ACCESS TOKEN URL
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$headers = ['Content-Type:application/json; charset=utf8'];
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$result = json_decode($result);

if ($result && isset($result->access_token)) {
    $access_token = $result->access_token;
} else {
    // Handle the case where the access token couldn't be retrieved
    echo "Error: Unable to fetch access token.\n";
}
?>
