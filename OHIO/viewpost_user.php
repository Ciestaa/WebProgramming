<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Get the username from your session or database
$username = $_SESSION["username"]; // Replace with the appropriate variable storing the username

if (isset($_POST["logout"])) {
    // Clear the session and redirect to the login page
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];

    // Add your database connection code here
    $conn = new mysqli('localhost', 'root', '', 'gotravel');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get the post ID and username
    $postID = $_POST['post_id']; // Replace with the appropriate variable storing the post ID

    // Check if the user has already rated the post
    $checkSql = "SELECT * FROM rating WHERE postID = '$postID' AND Username = '$username'";
    $checkResult = $conn->query($checkSql);

    $updateSql = "UPDATE rating SET Rating = '$rating' WHERE postID = '$postID' AND Username = '$username'";
    $insertSql = "INSERT INTO rating (postID, Username, Rating) VALUES ('$postID', '$username', '$rating')";

    if ($checkResult->num_rows > 0) {
        // User has already rated the post, update the existing rating
        $updateResult = $conn->query($updateSql);
        if ($updateResult === true) {
            echo "Rating updated successfully";
        } else {
            echo "Error updating rating: " . $conn->error;
        }
    } else {
        // User has not rated the post yet, insert a new rating
        $insertResult = $conn->query($insertSql);
        if ($insertResult === true) {
            echo "Rating inserted successfully";
        } else {
            echo "Error inserting rating: " . $conn->error;
        }
    }

    $conn->close(); // Close the database connection
    exit; // Stop further execution of the PHP code
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/postpageStyle.css">
    <script src="CSS/postpage.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
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
    <?php
  if (isset($_GET['post_id'])) {
      $postID = $_GET['post_id'];

      // Add your database connection code here
      $conn = new mysqli('localhost', 'root', '', 'gotravel');
      if ($conn->connect_error) {
          die('Connection failed: ' . $conn->connect_error);
      }

      // Fetch the post details using the provided post ID
      $sql = "SELECT * FROM posts WHERE postID = $postID";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Display the post details
          while ($row = $result->fetch_assoc()) {
              $title = $row['Title'];
              $description = $row['Description'];
              $image = $row['Image'];
              $location = $row['Location'];

              // Display the post details here
              echo '<div class="post-container">';
              echo '<h2>' . $title . '</h2>';
              echo '<p>' . $description . '</p>';
              echo '<img src="' . $image . '" alt="Post Image">';
              echo '</div>';
          }
      } else {
          echo "Post not found.";
      }

      $conn->close(); // Close the database connection
  } else {
      echo "Invalid post ID.";
  }
  ?>
    <div class="rating-container">
        <h5>Rate this blog:</h5>
        <form id="rating-form" method="post">
            <div class="rating">
                <span class="star" data-rating="1">&#9733;</span>
                <span class="star" data-rating="2">&#9733;</span>
                <span class="star" data-rating="3">&#9733;</span>
                <span class="star" data-rating="4">&#9733;</span>
                <span class="star" data-rating="5">&#9733;</span>
            </div>
            <input type="hidden" id="rating-value" name="rating" value="0">
            <input type="hidden" id="post-id" value="<?php echo $postID; ?>">
        </form>
    </div>

    <div class="comment-container">
        <h5>Comments</h2>
        <div class="comment-incontainer">
            <label for="Add_comment">Add comment:</label>
            <br>
            <textarea cols="110" rows="3" id="textarea" required style="width: 100%; box-sizing: border-box;""></textarea><br>
            <input type="submit" value="Submit" />
        </div>
        <div class="comment-incontainer">
            <img src="CSS/Images/profile.png" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">
            <h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">User123</h6>
            <br>
            <p style="margin-left: 60px;">Wow this place is good! I think i will go here with my  family soon</p>
        </div> 
        <div class="comment-incontainer">
            <img src="CSS/Images/Ano_Profile.png" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">
            <h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">Anonymous</h6>
            <br>
            <p style="margin-left: 60px;">Im handsome</p>
        </div> 
        <div class="comment-incontainer">
            <img src="CSS/Images/Ano_Profile.png" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">
            <h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">Anonymous</h6>
            <br>
            <p style="margin-left: 60px;">Im handsome</p>
        </div>
    </div>
    </div>
    
</body>

</html>
        