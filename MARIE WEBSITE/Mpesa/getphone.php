<?php
// Establish a connection to your XAMPP database using MySQLi or PDO
$servername = "localhost";
$username = "root";
$password = "";
$database = "booking_sample_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database to fetch the user's phone number
$userPhoneQuery = "SELECT phone_number FROM user_booking WHERE id = 4"; // Modify the query to match your database schema
$result = $conn->query($userPhoneQuery);

if ($result->num_rows > 0) {
    // Fetch the phone number from the result
    $row = $result->fetch_assoc();
    $userPhoneNumber = $row["phone_number"];

    // Assign the fetched phone number to Party A
    $PartyA = $userPhoneNumber;

    // Use the fetched phone number in your STK push file
    // Include your STK push file here and use the variable $PartyA in it
    include 'stkpush.php';
} else {
    echo "Error: Phone number not found in the database";
}

// Close the database connection
$conn->close();
?>
