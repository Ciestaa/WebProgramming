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
        <div class="post-container">
            <div class="post-content" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
              <h2>Trip to Bangkok</h2>
              <button class="btn btn-like">
                <i class="far fa-heart"></i>
              </button>
            </div>
            <p>Road here bengkang-bangkok</p>
            <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu mauris at risus aliquet semper. Sed euismod, magna eget dapibus lobortis, velit eros semper est, nec venenatis magna mauris at lectus. Vestibulum quis vulputate purus. Donec pharetra dolor ut arcu euismod consectetur.</p>
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <br>
            <a style="color:black" href="../OHIO/viewpost_user.html">View blog</a>
          </div>
          
        <div class="post-container">
            <div class="post-content" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
              <h2>Trip to Bangkok</h2>
              <button class="btn btn-like">
                <i class="far fa-heart"></i>
              </button>
            </div>
            <p>Road here bengkang-bangkok</p>
            <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu mauris at risus aliquet semper. Sed euismod, magna eget dapibus lobortis, velit eros semper est, nec venenatis magna mauris at lectus. Vestibulum quis vulputate purus. Donec pharetra dolor ut arcu euismod consectetur.</p>
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <img src="CSS/Images/bangkok.jpg" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">
            <br>
            <a style="color:black" href="../OHIO/viewpost_user.html">View blog</a>
          </div>  
    </div>
        

</body>

  
</html>
