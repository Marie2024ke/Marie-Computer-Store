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
$sql = "SELECT username, email, profile_picture, phone_number FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table style='width: 400px; border-collapse: collapse;' border='1'>";
    echo "<tr><th>Username</th><th>Email</th><th>Profile Picture</th><th>Phone Number</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["profile_picture"] . "</td><td>" . $row["phone_number"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();