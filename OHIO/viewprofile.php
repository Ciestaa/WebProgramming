<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Get the username from your session or database
$username = $_SESSION["username"];
// Define variables for the form fields
$comment = "";

// Retrieve the author parameter from the URL
$author = isset($_GET['author']) ? $_GET['author'] : '';

if (isset($_POST["logout"])) {
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

// Fetch the post details using the provided post ID
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

if ($result2->num_rows > 0) {
  // Loop through each row and fetch the data
  while ($row = $result2->fetch_assoc()) {
      // Access the data using column names
      $email = $row["Email"];
      // Retrieve other column values here

      // Do something with the data
      // ...
  }
} else {
  // No rows returned
  $email = "";
  // Handle the case when no user details are found
}

if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];

    // Add your database connection code here
    $conn = new mysqli('localhost', 'root', '', 'gotravel');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get the post ID
    $postID = $_POST['post_id'];

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

if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];

    // Add your database connection code here
    $conn = new mysqli('localhost', 'root', '', 'gotravel');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get the post ID
    $postID = $_POST['post_id'];

    date_default_timezone_set('Asia/Singapore');
    $currentDate = date('Y-m-d');

    // Insert the comment into the database
    $insertCommentSql = "INSERT INTO comment (postID, Username, Comment, Date) VALUES ('$postID', '$username', '$comment', '$currentDate')";
    $insertCommentResult = $conn->query($insertCommentSql);

    if ($insertCommentResult === true) {
        $comMes = "Comment inserted successfully";

        // Clear the form after inserting the comment
        $comment = ""; // Clear the comment field
    } else {
        $comMes = "Error inserting comment: " . $conn->error;
    }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function search() {
            var query = document.getElementById("search-bar").value;
            if (query !== "") {
                window.location.href = "../OHIO/searchUser.php?query=" + encodeURIComponent(query);
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
          <img src="../ProfilePage/<?php echo htmlspecialchars($ProfilePic); ?>" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
          <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.php"><?php echo htmlspecialchars($username); ?></a>
          <i class="bi bi-box-arrow-left text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();">LOG OUT</a>
          <form id="logout-form" method="post" style="display: none;">
            <input type="hidden" name="logout" value="1">
          </form>
        </div>
    </div>
      
    <div class="comment-container">
        <?php

        if (isset($_GET['post_id'])) {
            $postID = $_GET['post_id'];

            // Add your database connection code here
            $conn = new mysqli('localhost', 'root', '', 'gotravel');
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Update the TotalView column for the current post
            $sql = "UPDATE posts SET TotalView = TotalView + 1 WHERE postID = '$postID'";
            $conn->query($sql);
            
            // Fetch the post details using the provided post ID
            $sql = "SELECT p.*, u.* FROM posts p INNER JOIN userdetail u ON p.Username = u.username WHERE p.postID = '$postID'";
            $result = $conn->query($sql);
            

            if ($result->num_rows > 0) {
                // Display the post details
                while ($row = $result->fetch_assoc()) {
                    $usernamePost = $row['Username'];
                    $title = $row['Title'];
                    $description = $row['Description'];
                    $image = $row['Image'];
                    $location = $row['Location'];
                    $checkQuery = "SELECT * FROM userdetail WHERE username = '$username'";
                    $ProfilePic2 = $row['ProfilePic'];

                    // Display the post details here
                    echo '<img src="../ProfilePage/' . $ProfilePic2 . '"  alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">';
                    echo '<h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">'.$usernamePost.'</h6>';
                    echo '<br>';
                    echo '<p style="margin-left: 60px;">'. $location .'</p>';
                    echo '<h2>' . $title . '</h2>';
                    echo '<p>' . $description . '</p>';
                    if($image != null)
                    {   
                        echo '<div style="display: flex; justify-content: center; align-items: center; height: 400px; max-width: 3000;">';
                        echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 400px;">';
                        echo '</div>';

                    }

                }
            } else {
                echo "Post not found.";
            }

            $conn->close(); // Close the database connection
        } else if (isset($_GET['author'])) {
            $searchusername = isset($_GET['author']) ? $_GET['author'] : '';

            // Fetch user details using the provided username
            $sql = "SELECT * FROM userdetail WHERE Username = '$searchusername'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through the rows and access each user detail
                while ($row = $result->fetch_assoc()) {
                    // Access the user details here
                    // ...

                    // Retrieve the fullname from the row
                    $fullname = $row['FullName'];
                    $phone = $row['PhoneNo'];
                    $ProfilePic2 = $row['ProfilePic'];
                    $usernameProfile = $row['Username'];
                    $userGender = $row['Gender'];
                    $insta = $row['Instagram'];
                    $country = $row['CountryTravel'];
                    $year = $row['YearTravel'];
                    // Display the user details
                    
                    echo '<div class="user-container">';
                    echo '<img src="../ProfilePage/' . $ProfilePic2 . '"  alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">';
                    echo '<h5 style="display: inline-block; vertical-align: middle; margin-left: 10px;">'.$fullname.'</h5>';
                    echo '<br>';
                    echo '<p style="margin-left: 60px;"> @'. $usernameProfile .'</p>';

                    echo '<div style="display: flex; align-items: center;">';
                    echo '<h5 style="margin-left: 50px; font-size: 20px;">Instagram:</h5>';
                    echo '<a href="https://www.instagram.com/'.$insta.'" style="margin-left: 10px; font-size: 20px; text-decoration: none; color:black;">@'.$insta.'</a>';
                    echo '</div>';



                    echo '<h5 style="margin-left: 50px;">Gender: ' . $userGender . '</h5>';
                    echo '<h5 style="margin-left: 50px;">Country: ' . $country . '</h5>';
                    echo '<h5 style="margin-left: 50px;">Year(s) of experience: ' . $year . ' year(s)</h5>';
                    echo '<br>';
                    echo '<br>';
                    // Display other user details
                    // ...
                    echo '</div>';
                }
            } else {
                echo "User not found.";
            }
        }else{
            echo "Invalid parameter.";
        }
        
        

            echo'<center><h5>'. $_GET['author'] .' Posts</h2></center>';


        
        $conn = new mysqli('localhost', 'root', '', 'gotravel');
        if ($conn->connect_error) {
          die('Connection failed: ' . $conn->connect_error);
        }

        function fetchPosts($conn) {
          // Fetch post details with offset and limit
          $sql = "SELECT * FROM posts ORDER BY postID DESC";
          $result = $conn->query($sql);
          $userPageUsername = $_GET['author'];
          if ($result->num_rows > 0) {
            // Loop through the rows and access each post detail
            while ($row = $result->fetch_assoc()) {
              
              $PostID = $row['postID'];
              $usernamePOST = $row['Username'];
              $title = $row['Title'];
              $description = $row['Description'];
              $image = $row['Image'];
              $location = $row['Location'];
              if($usernamePOST == $userPageUsername){
              // Display the post details here
              echo '<div class="post-container">';
              echo '<div class="post-content" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">';
              echo '<h2>' . $title . '</h2>';
              echo '</div>';
              echo '<p style="text-align: justify;">' . truncateText($description, 500) . '</p>'; // Truncate to 500 characters
              if($image != null)
              { 
                echo '<img src="' . $image . '" alt="Post Image" style="max-width: 100%; height: 150px; margin: 10px 0;">';
                echo '<br>';
              }
              echo '<a style="color:black" href="../OHIO/viewpost_user.php?post_id=' . $PostID . '">View blog</a>';
              echo '</div>';

            }}
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
        </div>
       

       
            
            
            
    </div>

    <script type="text/javascript">
        function loadMoreComments() {
            var offset = document.getElementsByClassName('comment-incontainer').length; // Get the number of existing comments
            var limit = 10; // Number of comments to load per request

            // Show the loader
            $(".loader-div").show();

            // Make an AJAX request to load more comments
            $.ajax({
                url: 'load_more_comments.php', // Path to the PHP script handling the request
                type: 'POST',
                data: {
                offset: offset,
                limit: limit,
                post_id: <?php echo $postID; ?> // Pass the post ID to the PHP script
                },
                dataType: 'html',
                success: function (response) {
                // Hide the loader
                $(".loader-div").hide();

                // Append the loaded comments to the comment container
                $('.comment-container').append(response);
                },
                error: function (xhr, status, error) {
                // Hide the loader
                $(".loader-div").hide();

                console.error(error);
                }
            });
        }

</script>
    
</body>

</html>
        