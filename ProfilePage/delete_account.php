<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        echo "You are not logged in.";
        exit; // Stop execution
    }

    $username = $_SESSION["username"]; // Retrieve the username from the session

    // Database connection details
    $servername = "localhost";
    $dbusername = "root";
    $password = "";
    $dbname = "gotravel";

    // Create a new connection
    $conn = new mysqli($servername, $dbusername, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the query to check if the username exists
    $checkQuery = "SELECT * FROM user WHERE username = '$username'";

    // Execute the query
    $result = $conn->query($checkQuery);

    // Check if the username exists
    if ($result->num_rows > 0) {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Prepare the delete queries for related tables
            $deleteQuery1 = "DELETE FROM user WHERE username = '$username'";
            $deleteQuery2 = "DELETE FROM posts WHERE username = '$username'";
            $deleteQuery3 = "DELETE FROM rating WHERE username = '$username'";
            $deleteQuery4 = "DELETE FROM comment WHERE username = '$username'";
            $deleteQuery5 = "DELETE FROM userdetail WHERE username = '$username'";
            // Execute the delete queries
            $conn->query($deleteQuery1);
            $conn->query($deleteQuery2);
            $conn->query($deleteQuery3);
            $conn->query($deleteQuery4);
            $conn->query($deleteQuery5);

            // Commit the transaction
            $conn->commit();

            echo "You have deleted your account successfully.";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();

            echo "Error deleting user account: " . $e->getMessage();
        }
    } else {
        echo "Invalid username. Please try again.";
    }

    // Close the connection
    $conn->close();
}
?>