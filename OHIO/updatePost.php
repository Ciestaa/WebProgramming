<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the post ID, title, and description from the POST parameters
    $postID = $_POST['post_id'];
    $updatedTitle = $_POST['title'];
    $updatedDescription = $_POST['description'];

    // Add your database connection code here
    $conn = new mysqli('localhost', 'root', '', 'gotravel');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE posts SET Title = ?, Description = ? WHERE postID = ?");
    $stmt->bind_param("ssi", $updatedTitle, $updatedDescription, $postID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
}
?>
