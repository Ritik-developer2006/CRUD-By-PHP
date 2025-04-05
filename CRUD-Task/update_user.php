<?php
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = $_POST;

    $name = trim($postData['name']);
    $email = trim($postData['email']);
    $number = trim($postData['number']);
    $role = trim($postData['role']);
    $status = trim($postData['status']);

    // Validate input data
    if (empty($name) || empty($email) || empty($number) || empty($role) || empty($status)) {
        header("Location: index.php?error=All Fields are required!");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?error=Invalid email format!");
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" denotes string parameter
    $stmt->execute();
    $stmt->bind_result($emailCount);
    $stmt->fetch();
    $stmt->close();

    if ($emailCount > 0) {
        header("Location: index.php?error=Email already exists!");
        exit;
    }

    if (!preg_match("/^[0-9]{10}$/", $number)) {
        header("Location: index.php?error=Invalid phone number! Please enter a 10-digit number.");
        exit;
    }

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $target_dir = "images/";
        $fileName = basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES["photo"]["tmp_name"]);

        if (!in_array($fileType, $allowedTypes)) {
            header("Location: index.php?error=Invalid file type! Only JPG, PNG, and GIF are allowed.");
            exit;
        }

        $upload = move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        if (!$upload) {
            header("Location: index.php?error=Error in File Uploading!");
            exit;
        }
    } else {
        $fileName = trim($postData['prev_photo']);
    }

    $uid = trim($postData['uid']);

    $stmt = $conn->prepare("UPDATE users SET `name` = ?, `number` = ?, `email` = ?, `role` = ?, `photo` = ?, `status` = ? WHERE `uid` = ?");
    if ($stmt === false) {
        echo "Error preparing the statement.";
        exit;
    }

    $stmt->bind_param("sssssss", $name, $number, $email, $role, $fileName, $status, $uid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: index.php?message=User updated successfully!");
        exit;
    } else {
        header("Location: index.php?error=Update failed or no changes made!");
        exit;
    }
    $stmt->close();
}
$conn->close();
