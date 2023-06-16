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
              window.location.href = "../OHIO/searchUser.html?query=" + encodeURIComponent(query);
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
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/post_page_user.html">HOME</a>
          <i class="bi bi-plus text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/new_post.html">CREATE POST</a>
          <img src="userprofile.jpg" alt="Profile Image" style="border-radius: 50%; float: right; width: 30px; height: 30px;">
          <a style="font-weight: bold; color:white; font-size:medium;" href="../ProfilePage/index.html">James19</a>
          <i class="bi bi-box-arrow-left text-white"></i>
          <a style="font-weight: bold; color:white; font-size:small;" href="../OHIO/index.html">LOG OUT</a>
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
                <h3 class="name">3, 281</h3>
                <h4 class="title">Total Views</h4>
              </div>
            </div>
          </div>
              <div class="col-9 col-sm-6 col-md-4 col-lg-3">
            <div style="background-color:#f99f9e;" class="our-team">
              <div class="picture">
                <img class="img-fluid" src="heart.png">
              </div>
              <div  class="team-content">
                <h3 class="name">19, 855</h3>
                <h4 class="title">Total Likes</h4>
              </div>
            </div>
          </div>
              <div class="col-9 col-sm-6 col-md-4 col-lg-3">
            <div style="background-color:#bbdff9;" class="our-team">
              <div class="picture">
                <img class="img-fluid" src="comment.png">
              </div>
              <div class="team-content">
                <h3 class="name">661</h3>
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
    
    <body>

      <div class="chartContainer">
            <p class="white">Overview</p>
      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
      <script>
      // setup 
      const data = {
        labels: ['1/5', '2/5', '3/5', '4/5', '5/5', '6/5', '7/5'],
        datasets: [{
          label: 'Likes',
          data: [54, 30, 67, 98, 45, 39, 20],
          backgroundColor: [
            'rgba(255, 26, 104)',
          ],
          borderColor: [
            'rgba(255, 26, 104)',
           
          ],
          borderWidth: 1
        },{label: 'Comments',
          data: [18, 13, 6, 9, 12, 3, 40],
          backgroundColor: [
            'rgba(255,255,0)',
            
          ],
          borderColor: [
            'rgba(255,255,0)',
           
          ],
          borderWidth: 1
    
        }
    ]
      };
    
      // config 
      const config = {
        type: 'line',
        data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      };
    
      // render init block
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
    
      // Instantly assign Chart.js version
      const chartVersion = document.getElementById('chartVersion');
      chartVersion.innerText = Chart.version;
      </script>
      </div>
    </div>
    </body>