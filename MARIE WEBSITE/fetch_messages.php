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
$sql = "SELECT name, email FROM user_messages";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output data of each row in an HTML table
    echo "<table style='border-collapse: collapse; width: 100%;' border='1'>";
    echo "<tr><th>Name</th><th>Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
