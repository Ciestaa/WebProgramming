<?php
    if(isset($_POST["reset-password-submit"])) {

        $selector = $_POST["selector"];
        $validator = $_POST["alidator"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["password-repeat"];

        if (empty($password) || empty($passwordRepeat)) {
            //This wont work since the tokens are not included Fix: either send to start over
            header("Location: create-new-password.php?newpassword=empty");
            exit();
        } else if ($password != $passwordRepeat) {
            header("Location: create-new-password.php?newpassword=empty");
            exit();
        }

        $currentDate = date("U");

        require '../PHP/config.php';

        $sql = "SELECT * FROM passwordReset WHERE passwordResetSelector=? AND passwordResetExpires >= ?";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $selector, $currentDate); //currentDate
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
                echo "You need to re-submit your reset request";
                exit();
            } else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["passwordResetToken"]);

                if ($tokenCheck == false) {
                    echo "You need to re-submit your reset request";
                    exit();
                } elseif ($tokenCheck == true) {

                    $tokenEmail = $row['passwordResetEmail'];

                    // might need change according our database
                    $sql = "SELECT * FROM users WHERE emailUser=?;";

                    $stmt = mysqli_stmt_init($link);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error!";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            echo "There was an error!";
                            exit();
                        } else {

                            // might need to change ikut database
                            $sql = "UPDATE users SET passwordUsers=? WHERE emailUsers=?";
                            $stmt = mysqli_stmt_init($link);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error!";
                                exit();
                            } else {
                                // tukar kat sini jugak tukar user
                                $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM passwordReset WHERE passwordResetEmail=?";
                                $stmt = mysqli_stmt_init($link);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "There was an error!";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    // check where to send here tempat update password ada kaitan dgn signup
                                    header("Location: ../Login/login.php?newpassword=passwordupdated");
                                }
                            }
                        }
                    }
                }
                    
            }
        }


    } else {
        header("Location: Login.php");
    }
?>