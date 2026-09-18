<?php


function registerUser($pdo, $email, $username, $password) {
    $errors = [];

    // Validation
    if (empty($username)) $errors['username'] = "This field is required.";
    elseif (strlen($username) < 4) $errors['username'] = "Must be at least 4 characters.";
    elseif (strlen($username) > 50) $errors['username'] = "Username cannot exceed 20 characters.";

    if (empty($email)) $errors['email'] = "This field is required.";
    elseif (strlen($email) < 6) $errors['email'] = "Must be at least 6 characters.";
    elseif (strlen($email) > 150) $errors['email'] = "Email cannot exceed 50 characters.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format.";

    if (empty($password)) $errors['password'] = "This field is required.";
    elseif (strlen($password) < 8) $errors['password'] = "Must be at least 8 characters.";
    
    // Database Checks
    if (empty($errors)) {
        try {
            $checkStmt = $pdo->prepare("SELECT email, username FROM signupform WHERE email = ? OR username = ?");
            $checkStmt->execute([$email, $username]);
            $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                if ($existingUser['email'] === $email) $errors['email'] = "Email already exists!";
                if ($existingUser['username'] === $username) $errors['username'] = "Username already exists!";
            }

            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
                $stmt = $pdo->prepare("INSERT INTO signupform (email, username, hashed_password) VALUES (?,?,?)");
                $stmt->execute([$email, $username, $hashed_password]);
                
                return ['success' => true, 'errors' => []];
            }
        } catch (PDOException $e) {
            $errors['db_error'] = "Something went wrong. Please try again later.";
        }
    }
    return ['success' => false, 'errors' => $errors];
}
?>