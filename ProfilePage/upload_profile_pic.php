<?php
// Check if a file was uploaded without errors
if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] === 0) {
    $target_dir = "uploads/"; // Directory where the file will be stored
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]); // Path to the file
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension

    // Check if the file is a valid image format
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $allowedExtensions)) {
        // Move the uploaded file to the desired location
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            // File upload successful

            // Add your database connection code here
            $conn = new mysqli('localhost', 'root', '', 'gotravel');
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Prepare and bind the SQL statement
            $stmt = $conn->prepare("UPDATE userdetail SET ProfilePic = ?");
            $stmt->bind_param("s", $target_file);

            // Execute the SQL statement
            if ($stmt->execute()) {
                // Profile picture updated successfully
                echo '<script>alert("Profile picture uploaded and updated successfully.");</script>';
                echo '<script>history.back();</script>'; // Refresh the previous page
            } else {
                // There was an error updating the profile picture
                echo '<script>alert("Error updating the profile picture.");</script>';
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            // Failed to move the uploaded file
            echo '<script>alert("Failed to upload the profile picture.");</script>';
        }
    } else {
        // Invalid file format
        echo '<script>alert("Only JPG, JPEG, PNG, and GIF files are allowed.");</script>';
    }
} else {
    // No file uploaded or an error occurred
    echo '<script>alert("Error uploading the profile picture.");</script>';
}
?>
