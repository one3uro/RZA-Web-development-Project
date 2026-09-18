<?php

function loginUser($pdo, $email, $password) {
    try {
        $stmt = $pdo->prepare("SELECT username, hashed_password FROM signupform WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['hashed_password'])) {
                return ['success' => true, 'username' => $user['username']];
            } else {
                return ['success' => false, 'message' => 'Incorrect password', 'toastClass' => 'bg-danger'];
            }
        } else {
            return ['success' => false, 'message' => 'Email not found', 'toastClass' => 'bg-warning'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error', 'toastClass' => 'bg-danger'];
    }
}

function resetUserPassword($pdo, $email, $password, $confirmPassword) {
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        return ['success' => false, 'message' => 'All fields are required.', 'toastClass' => 'bg-warning'];
    } elseif (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password must be at least 6 characters long.', 'toastClass' => 'bg-warning'];
    } elseif ($password !== $confirmPassword) {
        return ['success' => false, 'message' => 'Passwords do not match.', 'toastClass' => 'bg-warning'];
    }

    try {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM signupform WHERE email = ?");
        $checkStmt->execute([$email]);
        
        if ($checkStmt->fetchColumn() > 0) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE signupform SET hashed_password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);

            return ['success' => true, 'message' => 'Password updated successfully. Redirecting to login...', 'toastClass' => 'bg-success'];
        } else {
            return ['success' => false, 'message' => 'Email address not found.', 'toastClass' => 'bg-danger'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'An error occurred. Please try again later.', 'toastClass' => 'bg-danger'];
    }
}
?>