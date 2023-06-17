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
      var input = document.getElementById("searchInput").value.toLowerCase();
      var filter = document.querySelector('input[name="filter"]:checked').id;
      var searchResults = document.getElementById("searchResults");
      var resultsHTML = "";

      if (filter === "filterAll") {

        // Replace ni untuk all
        resultsHTML += "<p>Filtered by: All</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";
      } else if (filter === "filterOption1") {
      
        // Replace ni untuk user
        resultsHTML += "<p>Filtered by: Option 1</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";
      } else if (filter === "filterOption2") {

        // Replace ni untuk post
        resultsHTML += "<p>Filtered by: Option 2</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";

        // Replace ni untuk location
        resultsHTML += "<p>Filtered by: Option 3</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";

        // Replace ni untuk title
        resultsHTML += "<p>Filtered by: Option 4</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";

        // Replace ni untuk author
        resultsHTML += "<p>Filtered by: Option 5</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";
        
        // Replace ni untuk rating
        resultsHTML += "<p>Filtered by: Option 6</p>";
        resultsHTML += "<p>Search keyword: " + input + "</p>";
      }
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
        <img src="CSS/Images/profile.png" alt="Profile Image"
            style="border-radius: 50%; float: right; width: 30px; height: 30px;">
        <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.php">James19</a>
        <i class="bi bi-box-arrow-left text-white"></i>
        <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/index.html">LOG OUT</a>
    </div>
  </div>
<div class="container">

 <!-- Filter Search -->
 <div class="filter-container">
    <label for="filterAll">All</label>
    <input type="radio" name="filter" id="filterAll" checked>
    <label for="filterOption1">User</label>
    <input type="radio" name="filter" id="filterOption1">
    <label for="filterOption2">Post</label>
    <input type="radio" name="filter" id="filterOption2">
    <label for="filterOption2">Location</label>
    <input type="radio" name="filter" id="filterOption3">
    <label for="filterOption2">Title</label>
    <input type="radio" name="filter" id="filterOption4">
    <label for="filterOption2">Author</label>
    <input type="radio" name="filter" id="filterOption5">
    <label for="filterOption2">Rating</label>
    <input type="radio" name="filter" id="filterOption6">
    <button onclick="applyFilter()">Apply</button>
  </div>
<?php
// Retrieve the search query from the URL parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Perform the search logic based on the query
if (!empty($query)) {
  // Perform your search logic here using the $query variable
  // Example: Query the database to search for users matching the query
  $conn = new mysqli('localhost', 'root', '', 'gotravel');
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  // Search for users
  $userSql = "SELECT * FROM userdetail WHERE Username LIKE '%$query%'";
  $userResult = $conn->query($userSql);

  // Search for posts
  $postSql = "SELECT * FROM posts WHERE Title LIKE '%$query%' OR Location LIKE '%$query%'";
  $postResult = $conn->query($postSql);

  // Display user search results
  if ($userResult->num_rows > 0) {
    echo '<h2>Search Results:</h2>';

    while ($userRow = $userResult->fetch_assoc()) {
      $username = $userRow['Username'];
      $fullName = $userRow['FullName'];
      $gender = $userRow['Gender'];
      $phoneNo = $userRow['PhoneNo'];
      $instagram = $userRow['Instagram'];
      $yearTravel = $userRow['YearTravel'];
      $countryTravel = $userRow['CountryTravel'];
      $profilePic = $userRow['ProfilePic'];

      // Display the post details here
      echo '<a href="../OHIO/viewpost_user.php?username=' . $username . '" class="white-box">';
      echo '<div class="box-text">';
      echo '<h2>' . $fullName . '</h2>';
      echo '<p>' . truncateText($phoneNo, 100) . '</p>';
      echo '</div>';
      echo '<div class="box-image">';
      if ($profilePic != null) {
        echo '<img src="../ProfilePage/' . $profilePic . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
        echo '<br>';
      }
      echo '</div>';
      echo '</a>';
      
    }
  }

  // Display post search results
  if ($postResult->num_rows > 0) {

    while ($postRow = $postResult->fetch_assoc()) {
      $postID = $postRow['postID'];
      $usernamePOST = $postRow['Username'];
      $title = $postRow['Title'];
      $description = $postRow['Description'];
      $image = $postRow['Image'];
      $location = $postRow['Location'];

      // Display the post details here
      echo '<a href="../OHIO/viewpost_user.php?post_id=' . $postID . '" class="white-box">';
      echo '<div class="box-text">';
      echo '<h2>' . $title . '</h2>';
      echo '<p>' . truncateText($description, 100) . '</p>';
      echo '</div>';
      echo '<div class="box-image">';
      if ($image != null) {
        echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">'; 
        echo '<br>';
      }
      echo '</div>';
      echo '</a>';
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