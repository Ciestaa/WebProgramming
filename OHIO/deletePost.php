<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the post ID from the POST parameters
    $postID = $_POST['post_id'];

    // Add your database connection code here
    $conn = new mysqli('localhost', 'root', '', 'gotravel');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare and execute the statement to delete comments
    $stmtComments = $conn->prepare("DELETE FROM comment WHERE postID = ?");
    $stmtComments->bind_param("i", $postID);
    if ($stmtComments->execute()) {
        $stmtComments->close();

        // Prepare and execute the statement to delete the post
        $stmtPost = $conn->prepare("DELETE FROM posts WHERE postID = ?");
        $stmtPost->bind_param("i", $postID);
        if ($stmtPost->execute()) {
            $stmtPost->close();
            echo "success";
        } else {
            echo "Error deleting post.";
        }
    } else {
        echo "Error deleting comments.";
    }

    $conn->close(); // Close the database connection
}
?>
