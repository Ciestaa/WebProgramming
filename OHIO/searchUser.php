<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Get the username from your session or database
$username = $_SESSION["username"]; // Replace with the appropriate variable storing the username

if(isset($_POST["logout"])){
  // Clear the session and redirect to the login page
  session_unset();
  session_destroy();
  header("location: index.php");
  exit;
}

$conn = new mysqli('localhost', 'root', '', 'gotravel');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM userdetail WHERE Username = '$username'"; // Enclose $username in quotes
$sql2 = "SELECT * FROM user WHERE Username = '$username'";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);

if ($result->num_rows > 0) {
    // Loop through each row and fetch the data
    while ($row = $result->fetch_assoc()) {
        // Access the data using column names
        $fullName = $row["FullName"];
        $gender = $row["Gender"];
        $phoneNo = $row["PhoneNo"];
        $ProfilePic = $row["ProfilePic"];
        $instagram = $row["Instagram"];
        $yearTravel = $row["YearTravel"];
        $countryTravel = $row["CountryTravel"];
        // Retrieve other column values here

        // Do something with the data
        // ...
    }
} else {
    // No rows returned
    $fullName = "";
    $gender = "";
    $phoneNo = "";
    $ProfilePic = "";
    $instagram = "";
    $yearTravel = "";
    $countryTravel = "";
    // Handle the case when no user details are found
}

// Retrieve the search query from the URL parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Retrieve the selected filter from the URL parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Initialize $filter if it is null
if ($filter === null) {
  $filter = 'filterAll';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Search Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function search() {
            var query = document.getElementById("search-bar").value;
            if (query !== "") {
                window.location.href = "../OHIO/searchUser.php?query=" + encodeURIComponent(query);
            }
        }
    </script>
    
    <!-- Filter Search punya function-->
    <script>
    function applyFilter() {
      var filter = document.querySelector('input[name="filter"]:checked').id;
      var urlParams = new URLSearchParams(window.location.search);
      urlParams.set('filter', filter);
      var newURL = window.location.pathname + '?' + urlParams.toString();
      window.location.href = newURL;
      }
    </script> 
</head>

<body>

    <div class="navbar">
        <div style="padding-left: 3%;" class="logo-container">
            <img src="CSS/Images/logo.png" alt="GoTravel Logo">
            <h1 class="logo-text" style="color:white;">Go-Travel</h1>
        </div>
    
        <div class="search-container">
          <form onsubmit="search(); return false;">
            <label for="search">Search:</label>
            <input type="text" id="search-bar" placeholder="Search for trips, user, or blog">
        </form>
        </div>
    
        <div class="nav-links">
          <i class="bi bi-house-door text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/post_page_user.php">HOME</a>
          <i class="bi bi-plus text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/new_post.php">CREATE POST</a>
          <img src="../ProfilePage/<?php echo htmlspecialchars($ProfilePic); ?>" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
          <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.php"><?php echo htmlspecialchars($username); ?></a>
          <i class="bi bi-box-arrow-left text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();">LOG OUT</a>
          <form id="logout-form" method="post" style="display: none;">
            <input type="hidden" name="logout" value="1">
          </form>
        </div>
  </div>
<div class="container">

  <!-- Filter Search -->
  <div class="filter-container">
    <label for="filterAll">All</label>
    <input type="radio" name="filter" id="filterAll" <?php if ($filter === 'filterAll' || $filter === null) echo 'checked'; ?>>
    <label for="filterOption1">User</label>
    <input type="radio" name="filter" id="filterOption1" <?php if ($filter === 'filterOption1') echo 'checked'; ?>>
    <label for="filterOption2">Title</label>
    <input type="radio" name="filter" id="filterOption2" <?php if ($filter === 'filterOption2') echo 'checked'; ?>>
    <label for="filterOption3">Location</label>
    <input type="radio" name="filter" id="filterOption3" <?php if ($filter === 'filterOption3') echo 'checked'; ?>>
    <label for="filterOption4">Rating</label>
    <input type="radio" name="filter" id="filterOption4" <?php if ($filter === 'filterOption4') echo 'checked'; ?>>
    <button onclick="applyFilter()">Apply</button>
  </div>
  <?php
// ...

// Perform the search logic based on the query and filter
if (!empty($query)) {
  // Perform your search logic here using the $query and $filter variables
  // Example: Query the database to search for users or posts based on the filter and query

  $conn = new mysqli('localhost', 'root', '', 'gotravel');
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  if (empty($filter) || $filter === 'filterAll') {
    // Perform search across all filters or specific logic for when no filter is selected
    $userSql = "SELECT * FROM userdetail WHERE Username LIKE '%$query%'";
    $userResult = $conn->query($userSql);

    $postSql = "SELECT * FROM posts WHERE Title LIKE '%$query%' OR Location LIKE '%$query%'";
    $postResult = $conn->query($postSql);

    // Display search results
    if ($userResult->num_rows > 0 || $postResult->num_rows > 0) {
      echo '<h2>Search Results:</h2>';

      while ($userRow = $userResult->fetch_assoc()) {
        // Display user details here
        echo '<a href="../OHIO/viewprofile.php?author=' . $userRow['Username'] . '" class="white-box">';
        echo '<div class="box-text">';
        echo '<h2>' . $userRow['FullName'] . '</h2>';
        echo '<p>' . truncateText($userRow['PhoneNo'], 100) . '</p>';
        echo '</div>';
        echo '<div class="box-image">';
        if ($userRow['ProfilePic'] != null) {
          echo '<img src="../ProfilePage/' . $userRow['ProfilePic'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
          echo '<br>';
        }
        echo '</div>';
        echo '</a>';
      }

      while ($postRow = $postResult->fetch_assoc()) {
        // Display post details here
        echo '<a href="../OHIO/viewpost_user.php?post_id=' . $postRow['postID'] . '" class="white-box">';
        echo '<div class="box-text">';
        echo '<h2>' . $postRow['Title'] . '</h2>';
        echo '<p>' . truncateText($postRow['Description'], 100) . '</p>';
        echo '</div>';
        echo '<div class="box-image">';
        if ($postRow['Image'] != null) {
          echo '<img src="' . $postRow['Image'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">'; 
          echo '<br>';
        }
        echo '</div>';
        echo '</a>';
      }
    } else {
      echo 'No results found.';
    }
  } else if ($filter === 'filterOption1') {
    // Perform user search logic based on the query
    $userSql = "SELECT * FROM userdetail WHERE Username LIKE '%$query%'";
    $userResult = $conn->query($userSql);

    // Display user search results
    if ($userResult->num_rows > 0) {
      echo '<h2>Search Results:</h2>';

      while ($userRow = $userResult->fetch_assoc()) {
        // Display user details here
        echo '<a href="../OHIO/viewpost_user.php?author=' . $userRow['Username'] . '" class="white-box">';
        echo '<div class="box-text">';
        echo '<h2>' . $userRow['FullName'] . '</h2>';
        echo '<p>' . truncateText($userRow['PhoneNo'], 100) . '</p>';
        echo '</div>';
        echo '<div class="box-image">';
        if ($userRow['ProfilePic'] != null) {
          echo '<img src="../ProfilePage/' . $userRow['ProfilePic'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
          echo '<br>';
        }
        echo '</div>';
        echo '</a>';
      }
    } else {
      echo 'No results found for users.';
    }
  } else if ($filter === 'filterOption2') {
    // Perform post search logic based on the query
    $postSql = "SELECT * FROM posts WHERE Title LIKE '%$query%'";
    $postResult = $conn->query($postSql);

    // Display post search results
    if ($postResult->num_rows > 0) {
      echo '<h2>Search Results:</h2>';

      while ($postRow = $postResult->fetch_assoc()) {
        echo '<a href="../OHIO/viewpost_user.php?post_id=' . $postRow['postID'] . '" class="white-box">';
        echo '<div class="box-text">';
        echo '<h2>' . $postRow['Title'] . '</h2>';
        echo '<p>' . truncateText($postRow['Description'], 100) . '</p>';
        echo '</div>';
        echo '<div class="box-image">';
        if ($postRow['Image'] != null) {
          echo '<img src="' . $postRow['Image'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">'; 
          echo '<br>';
        }
        echo '</div>';
        echo '</a>';
      }
    } else {
      echo 'No results found for posts.';
    }
  } else if ($filter === 'filterOption3') {
    // Perform post search logic based on the query
    $postSql = "SELECT * FROM posts WHERE Location LIKE '%$query%'";
    $postResult = $conn->query($postSql);

    // Display location search results
    if ($postResult->num_rows > 0) {
      echo '<h2>Search Results:</h2>';

      while ($postRow = $postResult->fetch_assoc()) {
        echo '<a href="../OHIO/viewpost_user.php?post_id=' . $postRow['postID'] . '" class="white-box">';
        echo '<div class="box-text">';
        echo '<h2>' . $postRow['Title'] . '</h2>';
        echo '<p>' . truncateText($postRow['Description'], 100) . '</p>';
        echo '</div>';
        echo '<div class="box-image">';
        if ($postRow['Image'] != null) {
          echo '<img src="' . $postRow['Image'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">'; 
          echo '<br>';
        }
        echo '</div>';
        echo '</a>';
      }
    } else {
      echo 'No results found for location.';
    }
  } else if ($filter === 'filterOption4') {
    // Perform post search logic based on the query and overall rating
    $postSql = "SELECT p.*, COALESCE(avg_rating.avg_rating, 0) AS avg_rating
                FROM posts p
                LEFT JOIN (
                  SELECT postID, AVG(rating) AS avg_rating
                  FROM rating
                  GROUP BY postID
                ) AS avg_rating ON p.postID = avg_rating.postID
                WHERE p.Title LIKE '%$query%' OR p.Location LIKE '%$query%'
                ORDER BY avg_rating DESC";

    $postResult = $conn->query($postSql);

    // Display post search results by overall rating
    if ($postResult->num_rows > 0) {
    echo '<h2>Search Results:</h2>';

    while ($postRow = $postResult->fetch_assoc()) {
    echo '<a href="../OHIO/viewpost_user.php?post_id=' . $postRow['postID'] . '" class="white-box">';
    echo '<div class="box-text">';
    echo '<h2>' . $postRow['Title'] . '</h2>';
    echo '<p>' . truncateText($postRow['Description'], 100) . '</p>';
    echo '</div>';
    echo '<div class="box-image">';
    if ($postRow['Image'] != null) {
    echo '<img src="' . $postRow['Image'] . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">'; 
    echo '<br>';
    }
    echo '</div>';
    echo '</a>';
    }
    } else {
    echo 'No results found for post.';
    }
  }
}
function truncateText($text, $limit) {
  if (strlen($text) > $limit) {
    $truncated = substr($text, 0, $limit);
    return $truncated . '...';
  }
  return $text;
}
?>
</div>
</body>


</html>