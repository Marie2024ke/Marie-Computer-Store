<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_sample";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Collect form data
$name = $_POST['user_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$amount = $_POST['finalAmount'];

// Insert the data into the database
$sql = "INSERT INTO user_booking (user_name, email, phone_number, finalAmount) VALUES ('$name', '$email', '$phone', '$amount')";

if (mysqli_query($conn, $sql)) {
    // Include stkpush.php and pass necessary data
    include 'Mpesa/stkpush.php';
    echo "Data submitted successfully!\n";
    echo "We will get back to you!\n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
// mysqli_close($conn); // Do not close here to avoid premature closure
?>
