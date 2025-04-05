<?php
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = $_POST;
    $uid = trim($postData['user_id']);
    $photo = trim($postData['prev_photo']);

    // Validate user ID (10 digits)
    if (strlen($uid) != 10) {
        header("Location: index.php?error=Invalid user id!");
        exit;
    }

    if (!empty($photo)) {
        $photoPath = "images/" . $photo;
        if (file_exists($photoPath)) {
            if (!unlink($photoPath)) {
                header("Location: index.php?error=Failed to delete photo file!");
                exit;
            }
        }
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE uid = ?");
    $stmt->bind_param("s", $uid);

    if ($stmt->execute()) {
        header("Location: index.php?message=User deleted successfully!");  // Redirect with success message
        exit;
    } else {
        header("Location: index.php?error=Failed to delete user from database!");  // Redirect with error message
        exit;
    }
    $stmt->close();
}
$conn->close();
