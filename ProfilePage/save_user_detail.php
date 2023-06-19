<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $response = array("success" => false, "message" => "You are not logged in.");
    echo json_encode($response);
    exit; // Stop execution
}

// Retrieve the user details from the form
$name = $_POST['fullName'];
$age = $_POST['age'];
$job = $_POST['job'];
$instagram = $_POST['instagram'];
$yearTravel = $_POST['yearTravel'];
$countryTravel = $_POST['countryTravel'];
$occ = $_POST['occ'];
$loc = $_POST['loc'];

$username = $_SESSION["username"]; // Retrieve the username from the session

// Database connection details
$servername = "localhost";
$dbusername = "root";
$password = "";
$dbname = "gotravel";

// Create a connection to the database
$conn = new mysqli($servername, $dbusername, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    $response = array("success" => false, "message" => "Connection failed: " . $conn->connect_error);
    echo json_encode($response);
    exit;
}

    // Prepare the query to check if the username exists
    $checkQuery = "SELECT * FROM user WHERE username = '$username'";

    // Execute the query
    $result = $conn->query($checkQuery);

    

if ($result->num_rows > 0) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare the delete queries for related tables
        $deleteQuery1 = "DELETE FROM userdetail WHERE username = '$username'";
        // Execute the delete queries
        $conn->query($deleteQuery1);

        // Commit the transaction
        $conn->commit();

    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();

        echo "Error deleting user account: " . $e->getMessage();
    }
} else {
    echo "Invalid username. Please try again.";
}
// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO userdetail (Username,FullName, Gender, PhoneNo, Instagram, YearTravel, CountryTravel,Occupation,Location) VALUES (?,?, ?, ?, ?, ?, ?,?,?)");
$stmt->bind_param("sssssssss", $username,$name, $age, $job, $instagram, $yearTravel, $countryTravel,$occ,$loc);

// Execute the SQL statement
if ($stmt->execute()) {
    // The user details were saved successfully
    $response = array("success" => true, "message" => "User details saved successfully.");
    echo json_encode($response);
} else {
    // There was an error saving the user details
    $response = array("success" => false, "message" => "Error: " . $stmt->error);
    echo json_encode($response);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
