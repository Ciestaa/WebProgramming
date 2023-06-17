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
                window.location.href = "../OHIO/searchUser.html?query=" + encodeURIComponent(query);
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
<?php
      $conn = new mysqli('localhost', 'root', '', 'gotravel');
      if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
      }

      function fetchPosts($conn) {
        // Fetch post details with offset and limit
        $sql = "SELECT * FROM posts ORDER BY postID DESC";
        $result = $conn->query($sql);

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
            
              echo'<a href="../OHIO/viewpost_user.php?post_id=' . $PostID . '" class="white-box">';
                echo'<div class="box-text">';
                  echo'<h2>'.$title.'</h2>';
                  echo'<p>' . truncateText($description, 100) . '</p>';
                echo'</div>';
                echo'<div class="box-image">';
                  if($image != null)
                    { 
                      echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
                      echo '<br>';
                    }
                echo'</div>';
              echo'</a>';
            
          }
        } else {
          echo "No posts found.";
        }
      }
      function truncateText($text, $limit) {
        if (strlen($text) > $limit) {
            $truncated = substr($text, 0, $limit);
            return $truncated . '...';
        }
        return $text;
      }

      // Fetch the first 10 post details
      fetchPosts($conn);
      ?>
</div>
</body>


</html>