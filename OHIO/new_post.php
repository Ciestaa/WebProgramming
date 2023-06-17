<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to the user post page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: ../OHIO/index.php");
    exit;
}

// Get the username from your session or database
$username = $_SESSION["username"];

if (isset($_POST["logout"])) {
    // Clear the session and redirect to the login page
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

// Include config file
require_once "../PHP/config.php";

// Create a new mysqli object
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$location = $title = $description = $image = "";
$post_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if title is empty
    if(empty(trim($_POST["title"]))){
        $post_err = "Please enter your story title.";
    } else{
        $title = trim($_POST["title"]);
    }
    
    // Check if story is empty
    if(empty(trim($_POST["story"]))){
        $post_err = "Please enter your story.";
    } else{
        $description = trim($_POST["story"]);
    }
    
    // Check if location is empty
    if(empty(trim($_POST["location"]))){
        $post_err = "Please enter your location.";
    } else{
        $location = trim($_POST["location"]);
    }

    // Check if image file is uploaded
    if(isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0){
        $target_dir = "uploads/"; // Directory where the file will be stored
        $target_file = $target_dir . basename($_FILES["picture"]["name"]); // Path to the file
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension
        
        // Validate file format
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if(in_array($imageFileType, $allowedExtensions)){
            // Move the uploaded file to the desired location
            if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)){
                $image = $target_file; // Set the image path
            } else {
                $post_err = "Failed to upload the image.";
            }
        } else {
            $post_err = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }
    
    // Check if there are no errors before inserting data into the database
    if (empty($post_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO posts (Username, Title, Description, Image, Location,TotalView) VALUES (?, ?, ?, ?, ?, 0)";

        if ($stmt = $mysqli->prepare($sql)) { // <-- Replace $conn with $mysqli
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $username, $title, $description, $image, $location);

            // Set the username parameter
            $username = $_SESSION["username"];

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to the post page or display a success message
                header("location: ../OHIO/post_page_user.php");
                exit;
            } else {
                $post_err = "Something went wrong. Please try again later.";
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Close the database connection
    $mysqli->close(); // <-- Replace $conn with $mysqli
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>New Post Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/new_post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <script>
        function search() {
            var query = document.getElementById("search-bar").value;
            if (query !== "") {
                window.location.href = "../OHIO/searchUser.php?query=" + encodeURIComponent(query);
            }
        }
    </script>
    
    <style>
        body {
            font-size: 18px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        textarea {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 18px;
            font-family: Arial, sans-serif;
            resize: none;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            padding: 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button:hover {
            background-color: #3e8e41;
        }
    </style>
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
            <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.php"><?php echo htmlspecialchars($username); ?></a>
            <i class="bi bi-box-arrow-left text-white"></i>
            <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/index.html">LOG OUT</a>
        </div>
    </div>

    <div class="container">
        <h1>Make a post about your breathtaking travel</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

        <label for="title">Enter your travel story title here:</label>
        <textarea id="title" name="title" required></textarea>

        <label for="story">Enter your travel story here:</label>
        <textarea id="story" name="story" required></textarea>

        <label for="picture">Upload a picture:</label>
        <input type="file" id="picture" name="picture">

        <label for="location">Enter your location of travel:</label>
        <input type="text" id="location" name="location" required>

        <?php if (!empty($login_err)): ?>
            <div class="error"><?php echo $post_err; ?></div>
        <?php endif; ?>

        <button type="submit">Submit</button>

        </form>
    </div>

    </body>
</html>