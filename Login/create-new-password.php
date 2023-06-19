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
      <h2>CHANGE PASSWORD</h2>
      
        <?php
            $selector = $GET["selector"];
            $selector = $GET["validator"];

            if (empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>

                    <!-- forgot password location -->
                    <form action="Forgotpassword.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector;?>">
                        <input type="hidden" name="validator" value="<?php echo $validator;?>">
                        <input type="password" name="pasword">
                        <input type="password" name="pasword-repeat">
                        <button type="submit" name="reset-password-submit">Reset Password</button>
                    </form>

                    <?php
                }
            }
        ?>

      </div>
  </form>
</body>


</html>