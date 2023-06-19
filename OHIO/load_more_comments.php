<?php
$conn = new mysqli('localhost', 'root', '', 'gotravel');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['offset']) && isset($_POST['limit']) && isset($_POST['post_id'])) {
    $offset = $_POST['offset'];
    $limit = $_POST['limit'];
    $postID = $_POST['post_id'];

    $conn = new mysqli('localhost', 'root', '', 'gotravel');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    function fetchComments($conn, $offset, $limit, $postID)
    {
        // Fetch comment details with offset and limit
        $sql = "SELECT p.*, u.* FROM comment p  INNER JOIN userdetail u ON p.Username = u.username WHERE p.postID = '$postID' ORDER BY comID DESC LIMIT $offset, $limit ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Loop through the rows and display each comment
            while ($row = $result->fetch_assoc()) {
                $usernameComment = $row['Username'];
                $comment = $row['Comment'];
                $ProfilePic2 = $row['ProfilePic'];

                // Display the comment details here
                echo '<div class="comment-incontainer">';
                echo '<img src="../ProfilePage/' . $ProfilePic2 . '" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">';
                echo '<h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">' . $usernameComment . '</h6>';
                echo '<br>';
                echo '<p style="margin-left: 60px;">' . $comment . '</p>';
                echo '</div> ';
            }
        } else {
            echo '<script>alert("No more comments to load.");</script>';
        }
    }

    // Fetch the comments based on the offset and limit
    fetchComments($conn, $offset, $limit, $postID);

    $conn->close();
}
?>


