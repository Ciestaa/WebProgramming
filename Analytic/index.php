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

if (isset($_POST["logout"])) {
  // Clear the session and redirect to the login page
  session_unset();
  session_destroy();
  header("location: ../OHIO/index.php");
  exit;
}

// Add your database connection code here
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

// Fetch the post details using the provided post ID
$sql = "SELECT SUM(comment_count) AS total_comment_count, SUM(total_view_sum) AS total_view_sum
        FROM (
            SELECT
              (SELECT COUNT(c.comID) FROM comment c WHERE c.postID = p.postID) AS comment_count,
              (SELECT COALESCE(SUM(p2.TotalView), 0) FROM posts p2 WHERE p2.postID = p.postID) AS total_view_sum
            FROM posts p
            WHERE p.Username = '$username'
        ) subquery";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each row and fetch the data
    while ($row = $result->fetch_assoc()) {
        // Access the data using column names
        $CommentCount = $row["total_comment_count"];
        $TotalView = $row["total_view_sum"];
        // Retrieve other column values here

        // Do something with the data
        // ...
    }
} else {
    // No rows returned
    // Set both comment count and total view to 0
    $CommentCount = 0;
    $TotalView = 0;
    // Handle the case when no user details are found
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

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
          <img src="logo.png" alt="GoTravel Logo">
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

    <div class="container">
        <div class="row">
          <div class="col-9 col-sm-6 col-md-4 col-lg-3">
            <div class="our-team">
              <div class="picture">
                <img class="img-fluid" src="view.png">
              </div>
              <div class="team-content">
                <h3 class="name"><?php echo htmlspecialchars($TotalView); ?></h3>
                <h4 class="title">Total Views</h4>
              </div>
            </div>
          </div>
          <div class="col-9 col-sm-6 col-md-4 col-lg-3">
            <div style="background-color:#bbdff9;" class="our-team">
              <div class="picture">
                <img class="img-fluid" src="comment.png">
              </div>
              <div class="team-content">
                <h3 class="name"><?php echo htmlspecialchars($CommentCount); ?></h3>
                <h4 class="title">Total Comments</h4>
              </div>
            </div>
          </div>
              
        </div>
      </div>
    


      <style>
        * {
          margin: 0px;
          font-family: sans-serif;
        }
        .chartMenu {
          width: 98vw;
          height: 40px;
          color: rgb(255, 255, 255,1.0);
        }
        .white{
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-weight: bolder;
            font-size: 24px;
        }
        .chartMenu p {
          
          font-size: 20px;
          display: flex;
        }
        .chartCard {
          width: 700px;
          height: calc(100-50)px;
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: rgb(255, 255, 255, 1.0);
          margin: 0 auto;
        }
        .chartBox {
          width: 670px;
          padding: 20px;
          border-radius: 2px;
          border: solid 3px rgba(230, 226, 226, 0.3);
          background: white;
        }
        .overview{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 2;
          font-weight: bold;
        }
        .chartContainer {
        width: 50%;
        margin: 0 auto;
        border-radius: 30px;
        border: solid 3px rgba(230, 226, 226, 0.3);
        overflow: hidden;
        background: white;
        }
      </style>
    

      <div class="chartContainer">
            <p class="white">Overview</p>
      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1"></script>
        <script>
          // Function to fetch data and update the chart
          function fetchData() {
            // Make an AJAX request to fetch the data
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updateChart(data);
              }
            };
            xhr.open('POST', 'fetch_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('post_id=123'); // Replace '123' with the actual post ID

          }

          // Function to update the chart with the fetched data
          function updateChart(data) {
            const ctx = document.getElementById('myChart').getContext('2d');

            // Create the chart
            const myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: data.labels,
                datasets: [{
                  label: 'Comments',
                  data: data.commentData,
                  backgroundColor: 'rgba(255,255,0)',
                  borderColor: 'rgba(255,255,0)',
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          }

          // Call the fetchData function to initially load the chart
          fetchData();
        </script>
      </div>
    </div>
</body>