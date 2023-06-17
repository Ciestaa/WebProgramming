<?php
session_start();

// Add your database connection code here
$conn = new mysqli('localhost', 'root', '', 'gotravel');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the session username
$username = $_SESSION['username'];

// Get the post ID
$postID = $_POST['post_id'];

// Retrieve comment data for the first 7 dates
$commentDataSql = "SELECT c.Date, COUNT(*) AS comment_count
                   FROM comment c
                   LEFT JOIN posts p ON c.postID = p.postID
                   WHERE p.Username = '$username'
                   GROUP BY c.Date
                   ORDER BY c.Date ASC
                   LIMIT 7";
$commentDataResult = $conn->query($commentDataSql);

if ($commentDataResult === false) {
    die('Error retrieving comment data: ' . $conn->error);
}

// Prepare the response data
$labels = array();
$commentData = array();

// Fetch the comment data and populate the labels and commentData arrays
while ($row = $commentDataResult->fetch_assoc()) {
    $labels[] = $row['Date'];
    $commentData[] = $row['comment_count'];
}

// If there are fewer than 7 dates, fill the remaining labels and commentData with 0
$remainingCount = 7 - count($labels);
for ($i = 0; $i < $remainingCount; $i++) {
    $labels[] = ""; // Empty label
    $commentData[] = 0; // Comment count of 0
}

// Convert the response data to JSON format
$response = array(
    'labels' => $labels,
    'commentData' => $commentData
);
$jsonResponse = json_encode($response);

// Send the JSON response
header('Content-Type: application/json');
echo $jsonResponse;
?>
