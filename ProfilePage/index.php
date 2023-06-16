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
    header("location: index.php");
    exit;
}

// Add your database connection code here
$conn = new mysqli('localhost', 'root', '', 'gotravel');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch the post details using the provided post ID
$sql = "SELECT * FROM userdetail WHERE Username = '$username'";
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
        $instagram = $row["Instagram"];
        $yearTravel = $row["YearTravel"];
        $countryTravel = $row["CountryTravel"];
        $ProfilePic =$row['ProfilePic'];

        // Retrieve other column values here

        // Do something with the data
        // ...
    }
} else {
    // No rows returned
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
  // Handle the case when no user details are found
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" />

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
      <img src="images/logo.png" alt="GoTravel Logo">
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
      <img src="images/profile/userprofile.jpg" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
      <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.html"><?php echo htmlspecialchars($username); ?></a>
      <i class="bi bi-box-arrow-left text-white"></i>
      <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/index.html">LOG OUT</a>
    </div>
    
</div>


  <section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
<!-- Student Profile -->
<div class="student-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
            <!-- <i class="bi bi-pen col-md-12 text-right" onclick="startNameEdit()"></i> -->
          
          <!-- <div class="card-header bg-transparent text-center">
            <label for="upload-profile-pic">
              <img class="profile_img" src="images/profile/userprofile.jpg" alt="student dp">
          </label>
          <input type="file" id="upload-profile-pic" style="display: none;">
             <h3 class="h2 mb-0 mr-2" contenteditable="true" id="name" onkeydown="handleNameEdit(event)">Ishmam Ahasan Samin</h3> 
            <h3 class="h2 mb-0 mr-2"></h3>
            <a href="../Analytic/index.html"><h6>Analytics</h6></a>
          </div> -->
          <div class="card-header bg-transparent text-center">
          <div class="popup" id="upload-popup">
    <span class="close-popup" onclick="closePopup()">&times;</span>
    <h4>Upload Profile Picture</h4>
    <form method="POST" action="upload_profile_pic.php" enctype="multipart/form-data">
        <input type="file" name="profile_pic" id="upload-profile-pic" accept=".jpg, .jpeg, .png, .gif">
        <button type="submit">Upload</button>
    </form>
</div>
            <img class="profile_img" src=<?php echo htmlspecialchars($ProfilePic);?> onclick="openPopup()">
            <h3 class="h2 mb-0 mr-2"><?php echo htmlspecialchars($fullName); ?></h3>
            <a href="../Analytic/index.php"><h6>Analytics</h6></a>
        </div>
          <div class="card-body">
            <p class="mb-0"><strong class="pr-1">Location: </strong>Singapore</p>
            <p class="mb-0"><strong class="pr-1">Occupation: </strong>Programmer</p>
            <p class="mb-0"><strong class="pr-1">Reviews: </strong><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <i class="bi bi-pen col-md-12 text-right" onclick="startEdit()"></i>
          
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0">ABOUT</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Name</th>
                <td width="2%">:</td>
                <td contenteditable="false" id="nama" type="text"><?php echo htmlspecialchars($fullName); ?></td>
              </tr>
              <tr>
                <th width="30%">Gender</th>
                <td width="2%">:</td>
                <td contenteditable="false" type="text" id="Gen"><?php echo htmlspecialchars($gender); ?></td>
              </tr>
              <tr>
                <th width="30%">Phone</th>
                <td width="2%">:</td>
                <td contenteditable="false" type="text" id="No"><?php echo htmlspecialchars($phoneNo); ?></td>
              </tr>
              <tr>
                <th width="30%">E-mail</th>
                <td width="2%">:</td>
                <td contenteditable="false" type="text" id="Email"><?php echo htmlspecialchars($email); ?></td>
              </tr>
              <tr>
                <th width="30%">Instagram</th>
                <td width="2%">:</td>
                <td contenteditable="false" type="text" id="Insta"><?php echo htmlspecialchars($instagram); ?></td>
              </tr>
            </table>
          </div>
        </div>
          <div style="height: 26px"></div>
        <div class="card shadow-sm">
          <!-- <i class="bi bi-pen col-md-12 text-right" onclick="startEdit()"></i> -->
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0">TRAVEL EXPERIENCES</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Year of Experience</th>
                <td width="2%">:</td>
                <td contenteditable="false" id="TE"><?php echo htmlspecialchars($yearTravel); ?></td>
              </tr>
              <tr>
                <th width="30%">Country</th>
                <td width="2%">:</td>
                <td contenteditable="false" id="Country"><?php echo htmlspecialchars($countryTravel); ?></td>
              </tr>
            </table>
            <div class="nav-links">
  <button style="font-weight: bold; color:black; font-size:small;" onclick="confirmDeleteAccount()">DELETE ACCOUNT</button>
</div>
          </div>
        </div>
      </div>
      </div>
  </div>
</div>


      <h4 class="mb-0 text-center">MY BLOG</h4>

  <body>
    <div class="container swiper">
      <div class="slide-container">
        <div class="card-wrapper swiper-wrapper">
          <div class="card swiper-slide">
            <div class="image-box">
              <a href="../OHIO/editPost.html"><img src="images/showImg/Paris.jpg" alt="" /></a>
            </div>
            <div class="profile-details">
              <img src="images/profile/userprofile.jpg" alt="" /></a>
              <div class="name-job">
                <h3 class="name">Trip to Bangkok</h3>
                <h4 class="job">5 February, 2021</h4>
              </div>
            </div>
          </div>
          <div class="card swiper-slide">
            <div class="image-box">
              <img src="images/showImg/Paris2.jpg" alt="" />
            </div>
            <div class="profile-details">
              <img src="images/profile/userprofile.jpg" alt="" />
              <div class="name-job">
                <h3 class="name">A day in Paris</h3>
                <h4 class="job">19 November, 2021</h4>
              </div>
            </div>
          </div>
          <div class="card swiper-slide">
            <div class="image-box">
              <img src="images/showImg/London.jpg" alt="" />
            </div>
            <div class="profile-details">
              <img src="images/profile/userprofile.jpg" alt="" />
              <div class="name-job">
                <h3 class="name">Family trip to Seoul</h3>
                <h4 class="job">18 June, 2022</h4>
              </div>
            </div>
          </div>
          <div class="card swiper-slide">
            <div class="image-box">
              <img src="images/showImg/Paris 3.jpg" alt="" />
            </div>
            <div class="profile-details">
              <img src="images/profile/userprofile.jpg" alt="" />
              <div class="name-job">
                <h3 class="name">Love Paris</h3>
                <h4 class="job">31 August, 1987</h4>
              </div>
            </div>
          </div>
          <div class="card swiper-slide">
            <div class="image-box">
              <img src="images/showImg/Seoul.jpg" alt="" />
            </div>
            <div class="profile-details">
              <img src="images/profile/userprofile.jpg" alt="" />
              <div class="name-job">
                <h3 class="name">Love the scenery here</h3>
                <h4 class="job">10 January, 2023</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-button-next swiper-navBtn"></div>
      <div class="swiper-button-prev swiper-navBtn"></div>
      <div class="swiper-pagination"></div>
    </div>

<script>
  function confirmDeleteAccount() {
  const username = prompt("Please enter your username to confirm account deletion:");
  if (username) {
    deleteAccount(username);
  }
}

function deleteAccount(username) {
  // Send an AJAX request to the server-side PHP script to handle the account deletion
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "delete_account.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert(xhr.responseText); // Display the response from the server
      // You can redirect the user to another page here if needed
    }
  };
  xhr.send("username=" + encodeURIComponent(username));
}
</script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
      
      function startNameEdit() {
        const nameElement = document.getElementById("name");
        nameElement.contentEditable = "true";
        nameElement.classList.add("border", "border-secondary");
        nameElement.focus();
      }
    
      function finishNameEdit() {
        const nameElement = document.getElementById("name");
        nameElement.contentEditable = "false";
        nameElement.classList.remove("border", "border-secondary");
      }
    
      function handleNameEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishNameEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const nameElement = document.getElementById("name");
          nameElement.innerText = nameElement.dataset.originalName;
          finishNameEdit();
        }}
    
        function startEdit() {
  const namaCell = document.getElementById("nama");
  const genCell = document.getElementById("Gen");
  const noCell = document.getElementById("No");
  const emailCell = document.getElementById("Email");
  const instaCell = document.getElementById("Insta");
  const teCell = document.getElementById("TE");
  const countryCell = document.getElementById("Country");

  namaCell.contentEditable = true;
  genCell.contentEditable = true;
  noCell.contentEditable = true;
  emailCell.contentEditable = false;
  instaCell.contentEditable = true;
  teCell.contentEditable = true;
  countryCell.contentEditable = true;

  namaCell.focus();
}

document.addEventListener("keydown", function(event) {
  if (event.key === "Enter") {
    const namaCell = document.getElementById("nama");
    const genCell = document.getElementById("Gen");
    const noCell = document.getElementById("No");
    const emailCell = document.getElementById("Email");
    const instaCell = document.getElementById("Insta");
    const teCell = document.getElementById("TE");
    const countryCell = document.getElementById("Country");

    namaCell.contentEditable = false;
    genCell.contentEditable = false;
    noCell.contentEditable = false;
    emailCell.contentEditable = false;
    instaCell.contentEditable = false;
    teCell.contentEditable = false;
    countryCell.contentEditable = false;

    const h3Element = document.querySelector("h3.h2.mb-0.mr-2");
    h3Element.textContent = namaCell.textContent;

    // Retrieve the username from the current session (replace with your actual method)

    // Prepare the data to be sent to the server
    const data = {
      fullName: namaCell.textContent,
      age: genCell.textContent,
      job: noCell.textContent,
      instagram: instaCell.textContent,
      yearTravel: teCell.textContent,
      countryTravel: countryCell.textContent
    };

    // Send the data to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_user_detail.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Request was successful, handle the server's response if needed
          console.log(xhr.responseText);
        } else {
          // Request failed, handle the error
          console.error("Error:", xhr.status);
        }
      }
    };
    xhr.send("fullName=" + encodeURIComponent(data.fullName) + "&age=" + encodeURIComponent(data.age) + "&job=" + encodeURIComponent(data.job) + "&instagram=" + encodeURIComponent(data.instagram) + "&yearTravel=" + encodeURIComponent(data.yearTravel) + "&countryTravel=" + encodeURIComponent(data.countryTravel));
  }
});


      
    
      function finishTEEdit() {
        const TEElement = document.getElementById("TE");
        TEElement.contentEditable = "false";
        TEElement.classList.remove("border", "border-secondary");
      }
    
      function handleTEEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishTEEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const TEElement = document.getElementById("TE");
          TEElement.innerText = TEElement.dataset.originalName;
          finishTEEdit();
        }}

        function finishCountryEdit() {
        const CountryElement = document.getElementById("Country");
        CountryElement.contentEditable = "false";
        CountryElement.classList.remove("border", "border-secondary");
      }
    
      function handleCountryEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishCountryEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const CountryElement = document.getElementById("Country");
          CountryElement.innerText = CountryElement.dataset.originalName;
          finishCountryEdit();
        }}

        function finishEmailEdit() {
        const EmailElement = document.getElementById("Email");
        EmailElement.contentEditable = "false";
        EmailElement.classList.remove("border", "border-secondary");
      }
    
      function handleEmailEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishEmailEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const EmailElement = document.getElementById("Email");
          EmailElement.innerText = EmailElement.dataset.originalName;
          finishEmailEdit();
        }}

        function finishInstaEdit() {
        const InstaElement = document.getElementById("Insta");
        InstaElement.contentEditable = "false";
        InstaElement.classList.remove("border", "border-secondary");
      }
    
      function handleInstaEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishInstaEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const InstaElement = document.getElementById("Insta");
          InstaElement.innerText = InstaElement.dataset.originalName;
          finishInstaEdit();
        }}

        function finishNoEdit() {
        const NoElement = document.getElementById("No");
        NoElement.contentEditable = "false";
        NoElement.classList.remove("border", "border-secondary");
      }
    
      function handleNoEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishNoEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const NoElement = document.getElementById("No");
          NoElement.innerText = NoElement.dataset.originalName;
          finishNoEdit();
        }}

        function finishGenEdit() {
        const GenElement = document.getElementById("Gen");
        GenElement.contentEditable = "false";
        GenElement.classList.remove("border", "border-secondary");
      }
    
      function handleGenEdit(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          finishGenEdit();
        } else if (event.key === "Escape") {
          event.preventDefault();
          const GenElement = document.getElementById("Gen");
          GenElement.innerText = GenElement.dataset.originalName;
          finishGenEdit();
        }}
      ;
      
    </script>
  </body>
</html>
