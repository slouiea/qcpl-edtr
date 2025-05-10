<?php
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login_system"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>