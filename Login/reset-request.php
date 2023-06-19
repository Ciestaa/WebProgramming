<?php

// To create token
if (isset($_POST["reset-request-submit"])) {
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    // CHANGE THIS TO CHANGE PASSWORD LINK
    $url = "localhost/Project/WebProgramming/Login/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token); 

    //expire date for token
    $expires = date("U") + 1800; // 1 hour

    // test
    require '../PHP/config.php';

    $userEmail = $_POST["email"];

    $sql = "DELETE FROM passwordReset WHERE passwordResetEmail=?";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO passwordReset (passwordResetEmail, passwordResetSelector, passwordResetToken, passwordResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

    $to = $userEmail;

    $subject = 'Reset your password for Go Travel';

    $message = '<p>We received a password reset request. The link to reset your password is here</br>';
    $message .= '<a href="' . $url . '">' . $url . '</a></p>';

    $headers = "From: admin <ohiogotravel@gmail.com>\r\n";
    $headers .= "Reply-To: ohiogotravel@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    // FORGOT PASSWORD PAGE LOCATION
    header("Location: ../Login/Forgotpassword.php?reset=success");

} else {
    header("Location: Login.php");
}