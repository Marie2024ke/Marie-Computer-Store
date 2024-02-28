<?php
// Establishing connection to the database
$servername = "localhost"; // Assuming your XAMPP server is running locally
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "booking_sample"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from your table
$sql = "SELECT user_name, email, finalAmount, phone_number FROM user_booking";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output data of each row in an HTML table
    echo "<table style='border-collapse: collapse; width: 100%;' border='1'>";
    echo "<tr><th>Username</th><th>Email</th><th>Amount Picture</th><th>Phone Number</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["user_name"]."</td><td>".$row["email"]."</td><td>".$row["finalAmount"]."</td><td>".$row["phone_number"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
