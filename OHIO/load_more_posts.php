<?php
$conn = new mysqli('localhost', 'root', '', 'gotravel');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['offset']) && isset($_POST['limit'])) {
    $offset = $_POST['offset'];
    $limit = $_POST['limit'];

    // Fetch post details with offset and limit
    $sql = "SELECT * FROM posts ORDER BY postID DESC LIMIT $offset, $limit";
    $result = $conn->query($sql);

    function limitWords($string, $wordLimit) {
        $words = explode(' ', $string);
        if (count($words) > $wordLimit) {
            $words = array_slice($words, 0, $wordLimit);
            $string = implode(' ', $words) . '...';
        }
        return $string;
    }   
    

    if ($result->num_rows > 0) {
        // Loop through the rows and access each post detail
        while ($row = $result->fetch_assoc()) {
            $PostID = $row['postID'];
            $usernamePOST = $row['Username'];
            $title = $row['Title'];
            $description = $row['Description'];
            $image = $row['Image'];
            $location = $row['Location'];
            

            // Display the post details here
            echo '<div class="post-container">';
            echo '<div class="post-content" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">';
            echo '<h2>' . $title . '</h2>';
            echo '</div>';
            echo '<p style="text-align: justify;">' . limitWords($description, 100) . '</p>';
            if($image != null)
            { 
              echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
              echo '<br>';
            }
            echo '<a style="color:black" href="../OHIO/viewpost_user.php?post_id=' . $PostID . '">View blog</a>';
            echo '</div>';
        }
    } else {
        echo '<script>alert("No more posts to load.");</script>';
    }
}

$conn
?>