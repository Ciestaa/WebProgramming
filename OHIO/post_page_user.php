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


?>

<!DOCTYPE html>
<html>
<head>


    <title>Post Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/postpageStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      function search() {
            var query = document.getElementById("search-bar").value;
            if (query !== "") {
                window.location.href = "../OHIO/searchUser.html?query=" + encodeURIComponent(query);
            }
        }

        function loadMorePosts() {
            var offset = 0; // Initial offset value
            var limit = 10; // Number of posts to load

            // Call the fetchPosts function with the updated offset and limit values
            fetchPosts(offset, limit);

            // Update the offset for the next set of posts
            offset += limit;
        }
    </script>

</head>

<body>
    <div class="navbar">
        <div style="padding-left: 3%;"class="logo-container">
          <img src="CSS/Images/logo.png" alt="GoTravel Logo">
          <h1 class="logo-text" style="color:white;" >Go-Travel</h1>
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
          <img src="CSS/Images/profile.png" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
          <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.php"><?php echo htmlspecialchars($username); ?></a>
          <i class="bi bi-box-arrow-left text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();">LOG OUT</a>
          <form id="logout-form" method="post" style="display: none;">
            <input type="hidden" name="logout" value="1">
          </form>
        </div>
    </div>

    <div class="post-section">
    <div id="post-container">
        <?php
      $conn = new mysqli('localhost', 'root', '', 'gotravel');
      if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
      }

      function fetchPosts($conn, $offset, $limit) {
        // Fetch post details with offset and limit
        $sql = "SELECT * FROM posts LIMIT $offset, $limit";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Loop through the rows and access each post detail
          while ($row = $result->fetch_assoc()) {
            $postID = $row['postID'];
            $usernamePOST = $row['Username'];
            $title = $row['Title'];
            $description = $row['Description'];
            $image = $row['Image'];
            $location = $row['Location'];

            // Display the post details here
            echo '<div class="post-container">';
            echo '<div class="post-content" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">';
            echo '<h2>' . $title . '</h2>';
            echo '<button class="btn btn-like">';
            echo '<i class="far fa-heart"></i>';
            echo '</button>';
            echo '</div>';
            echo '<p style="text-align: justify;">' . $description . '</p>';
            echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
            echo '<br>';
            echo '<a style="color:black" href="../OHIO/viewpost_user.php?post_id=' . $postID . '">View blog</a>';
            echo '</div>';
          }
        } else {
          echo "No posts found.";
        }
      }

      // Fetch the first 10 post details
      fetchPosts($conn, 0, 10);
      ?>
    </div>
    <center>
        <button type="button" class="btn btn-success" onclick="loadMorePosts()">Load More</button>
    </center>
    <div class="loader-div" style="display: none;">Loading...</div>
</div>

<script type="text/javascript">
    function loadMorePosts() {
        var offset = document.getElementsByClassName('post-container').length; // Get the number of existing posts
        var limit = 10; // Number of posts to load per request

        // Make an AJAX request to load more posts
        $.ajax({
            url: 'load_more_posts.php', // Path to the PHP script handling the request
            type: 'POST',
            data: {
                offset: offset,
                limit: limit
            },
            dataType: 'html',
            success: function(response) {
                // Append the loaded posts to the existing post container
                $('#post-container').append(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>

</body>

  
</html>
