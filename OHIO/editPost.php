<!DOCTYPE html>
<html>
<head>
    <title>Edit Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/editPost.css">
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
    <script>
      function confirmDelete(event) {
        event.preventDefault(); // Prevents the link from navigating

        // Create the confirmation popup
        var confirmPopup = document.createElement("div");
        confirmPopup.className = "popup";

        var confirmMessage = document.createElement("p");
        confirmMessage.textContent = "Are you sure you want to delete the post?";
        confirmPopup.appendChild(confirmMessage);

        var yesButton = document.createElement("button");
        yesButton.textContent = "Yes";
        yesButton.className = "red-button";
        yesButton.onclick = function() {
          confirmPopup.remove(); // Remove the confirmation popup
          deletePost(); // Delete the post and comments
        };
        confirmPopup.appendChild(yesButton);

        var noButton = document.createElement("button");
        noButton.textContent = "No";
        noButton.className = "white-button";
        noButton.onclick = function() {
          confirmPopup.remove(); // Remove the confirmation popup
        };
        confirmPopup.appendChild(noButton);

        document.body.appendChild(confirmPopup); // Append the confirmation popup to the body
      }

      function deletePost() {
        // Retrieve the postID from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var postID = urlParams.get("post_id");

        // Send an AJAX request to delete the post and comments
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deletePost.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === "success") {
                        alert("Post and comments deleted successfully.");
                        window.location.href = "../OHIO/post_page_user.php"; // Redirect to a new page
                    } else {
                        console.error(response);
                        alert("Error deleting post and comments. Please check the console for more details.");
                    }
                } else {
                    console.error("Request failed. Status: " + xhr.status);
                    alert("Error deleting post and comments. Please check the console for more details.");
                }
            }
        };
        xhr.send("post_id=" + encodeURIComponent(postID));
      }
    </script>
        <script>
          function editText() {
            var titleElement = document.getElementById("title");
            var detailsElement = document.getElementById("details");
            
            // Retrieve the postID from the URL
            var urlParams = new URLSearchParams(window.location.search);
            var postID = urlParams.get("post_id");
          
            // Toggle contenteditable attribute
            titleElement.contentEditable = !titleElement.isContentEditable;
            detailsElement.contentEditable = !detailsElement.isContentEditable;
          
            // Apply styling for editable state
            if (titleElement.isContentEditable) {
              titleElement.style.backgroundColor = "lightyellow";
              detailsElement.style.backgroundColor = "lightyellow";
            } else {

              const data = {
                updatedTitle: titleElement.textContent,
                updatedDescription: detailsElement.textContent,
              };

              var xhr = new XMLHttpRequest();
                xhr.open("POST", "updatePost.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        if (response === "success") {
                            alert("Post updated successfully.");
                        } else {
                            alert("Error updating post.");
                        }
                    }
                };
                xhr.send("post_id=" + encodeURIComponent(postID) + "&title=" + encodeURIComponent(data.updatedTitle) + "&description=" + encodeURIComponent(data.updatedDescription));

              titleElement.style.backgroundColor = "transparent";
              detailsElement.style.backgroundColor = "transparent";
              showPopup();
            }
          }
          
          function showPopup() {
            var popup = document.createElement("div");
            popup.style.position = "fixed";
            popup.style.top = "50%";
            popup.style.left = "50%";
            popup.style.transform = "translate(-50%, -50%)";
            popup.style.backgroundColor = "lightblue";
            popup.style.padding = "10px";
            popup.style.border = "1px solid gray";
            popup.style.borderRadius = "5px";
            popup.textContent = "The post has been edited";
          
            document.body.appendChild(popup);
          
            setTimeout(function() {
              popup.parentNode.removeChild(popup);
            }, 2000);
          }
          
          document.addEventListener("keydown", function(event) {
            if (event.keyCode === 13) { // 13 corresponds to the "Enter" key
                editText();
            }
          });

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
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/post_page_user.html">HOME</a>
          <i class="bi bi-plus text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/new_post.html">CREATE POST</a>
          <img src="CSS/Images/profile.png" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
          <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.html">James19</a>
          <i class="bi bi-box-arrow-left text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/index.html">LOG OUT</a>
        </div>
        
    </div>
    
    <div class="white-box">
      <!-- <div class="box-date">
        May 5, 2023 - 2:00 PM
      </div> 
    removed time
    -->
    <?php

    if (isset($_GET['post_id'])) {
        $postID = $_GET['post_id'];

        // Add your database connection code here
        $conn = new mysqli('localhost', 'root', '', 'gotravel');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

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
                echo '<div class="box-image">';
                if ($image != null) {
                    echo '<img src="' . $image . '" alt="Post Image">';
                } else {
                    echo '<img src="CSS/Images/bangkok.jpg" alt="Placeholder image">';
                }
                echo '</div>';

                echo '<div class="box-text">';
                echo '<h2 id="title">' . $title . '</h2>';
                echo '<p id="details">' . $description . '</p>';
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

      <div class="box-buttons">
        <a href="#">
          <button onclick="editText()">Edit</button>
        </a>

        <!-- <a href="#">
          <button>Archive</button>
        </a> 
        remove archieve button
        -->
        <a onclick="confirmDelete(event)">
          <button>Delete</button>
        </a>
      </div>
    </div>
      
      
      
</body>


</html>