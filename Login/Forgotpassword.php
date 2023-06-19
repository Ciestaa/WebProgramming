<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Forgotpassword.css">
</head>

<body>
  <form action="#">
      <h2>FORGOT PASSWORD</h2>
      <h4>We'll send you reset password info to the following email address.</h4>
      <div class="inset br">
        <form action="reset-request.php" method="post">
          <label for="email">Email Address</label>
          <input type="text" name="email" id="email">
          <button type="submit" name="reset-request-submit">Send</button>
          <span><a href="../Login/Login.php">Back To Login</a></span>
        </form>
        <?php
          if (isset($_GET["reset"])) {
            // need to update this class
            echo '<p class = "">Check your email!</p>';
          }
        ?>
      </div>
  </form>
</body>


</html>