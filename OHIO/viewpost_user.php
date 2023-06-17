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

    $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD

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
            $sql = "SELECT * FROM posts WHERE postID = '$postID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display the post details
                while ($row = $result->fetch_assoc()) {
                    $usernamePost = $row['Username'];
                    $title = $row['Title'];
                    $description = $row['Description'];
                    $image = $row['Image'];
                    $location = $row['Location'];

                    // Display the post details here
                    echo '<img src="CSS/Images/profile.png" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">';
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
        } else {
            echo "Invalid post ID.";
        }
        ?>
        </div>
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

            <?php
            if (isset($_GET['post_id'])) {
            $postID = $_GET['post_id'];

            $conn = new mysqli('localhost', 'root', '', 'gotravel');
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }
            $sql = "SELECT * FROM rating";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $ratingCollect = [];
            // Loop through the rows and access each post detail
                while ($row = $result->fetch_assoc()) {
                    $PostIDRating = $row['postID'];
                    $usernameRating = $row['Username'];
                    $ratingvalue = $row['Rating'];

                    

                    $encodedUsername = htmlspecialchars($username);

                    if (($PostIDRating == $postID) && ($usernameRating == $encodedUsername)) {
                        echo '<h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">You have rated '.$ratingvalue.' star(s) for this blog</h6>';
                    }

                    if ($PostIDRating == $postID) {
                        $ratingCollect[] = $ratingvalue;
                        
                    }
                }
                if($ratingCollect != null)
                {$ratingSum = array_sum($ratingCollect);
                    $averageRating = $ratingSum / count($ratingCollect);
                    echo "Overall Ratings: " . $averageRating . " Star(s)";}
        
        }
    }
            ?>
        </div>

        <div class="comment-container">
            <h5>Comments</h2>
            <div class="comment-incontainer">
                <form id="comment-form" method="post">
                    <label for="comment">Add comment:</label>
                    <br>
                    <textarea cols="110" rows="3" id="comment" name="comment" required style="width: 100%; box-sizing: border-box;"><?php echo htmlspecialchars($comment); ?></textarea><br>
                    <input type="hidden" id="post-id" value="<?php echo $postID; ?>">
                    <input type="submit" value="Submit">
                </form>
            </div>

            <!-- Start of the comment section -->
            <?php
            if (isset($_GET['post_id'])) {
                $postID = $_GET['post_id'];

        
                $conn = new mysqli('localhost', 'root', '', 'gotravel');
                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }

                function fetchPosts($conn, $offset, $limit,$postID) {
                    // Fetch post details with offset and limit
                    $sql = "SELECT * FROM comment ORDER BY comID DESC LIMIT $offset, $limit";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                    // Loop through the rows and access each post detail
                    while ($row = $result->fetch_assoc()) {
                        $PostIDCom = $row['postID'];
                        $usernameComment = $row['Username'];
                        $comments = $row['Comment'];

                        if($PostIDCom == $postID)
                        {
                            // Display the post details here
                            echo '<div class="comment-incontainer">';
                            echo '<img src="CSS/Images/profile.png" alt="Profile Image" style="border-radius: 50%; float: left; width: 50px; height: 50px;">';
                            echo '<h6 style="display: inline-block; vertical-align: middle; margin-left: 10px;">'.$usernameComment.'</h6>';
                            echo '<br>';
                            echo '<p style="margin-left: 60px;">'. $comments .'</p>';
                            echo '</div> ';
                        }
                    }
                    } else {
                    echo "No posts found.";
                    }
                }

                // Fetch the first 10 post details
                fetchPosts($conn, 0, 10,$postID);
            }
            ?>
            
            
            </div>
            <center>
                <button type="button" class="btn btn-success" onclick="loadMoreComments()">Load More</button>
            </center>
            <div class="loader-div" style="display: none;">Loading...</div>
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
        