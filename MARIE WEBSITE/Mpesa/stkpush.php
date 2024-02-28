<?php
// INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';

date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$callbackurl = 'https://kariukijames.com/pesa/callback.php';
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
// ENCRYPT DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

// Fetch phone number from database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_sample"; // Update with your actual database name

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT phone_number, finalAmount FROM user_booking ORDER BY id DESC LIMIT 1"; // Assuming the latest entry is the most recent one
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $phone = $row['phone_number'];
    $finalAmount = $row['finalAmount'];
} else {
    echo "Error: No data found in the database.";
    exit;
}

// INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token]); //setting custom header
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);

$curl_post_data = json_encode([
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $finalAmount,
    'PartyA' => $phone,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $phone,
    'CallBackURL' => $callbackurl,
    'AccountReference' => 'Marie Computer Store', // Assuming this is constant
    'TransactionDesc' => 'stkpush test', // Assuming this is constant
]);

curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

$curl_response = curl_exec($curl);

if ($curl_response === false) {
    $error_message = curl_error($curl);
    echo "cURL error occurred: $error_message";
} else {
    // Log the response for debugging
    echo "M-Pesa API Response: " . $curl_response . "\n";
    file_put_contents('stkpush_response.log', $curl_response);

    $data = json_decode($curl_response);

    if ($data && isset($data->ResponseCode)) {
        $ResponseCode = $data->ResponseCode;

        if ($ResponseCode == "0") {
            echo "Data submitted successfully! We will get back to you!\n";
        } else {
            echo "Error: " . $data->errorMessage . "\n";
        }
    } else {
        echo "Error: Invalid response from M-Pesa API.\n";
    }
}

// Close the CURL connection
curl_close($curl);

// Close the database connection
mysqli_close($conn);
?>
