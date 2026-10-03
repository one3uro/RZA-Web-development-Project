<?php

//Filter and sum the total amount of hotel bookings made
function totalBookings(PDO $pdo, int $user_id): int {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
        FROM reservations
        WHERE booking_type = 'hotel'
        AND user_id = :user_id;"
    );
    $stmt->execute(['user_id' => $user_id]);

    return (int) $stmt->fetchColumn();
}

//Filter and sum the total amount of zoo bookings made
function totalticket(PDO $pdo, int $user_id): int {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
        FROM reservations
        WHERE booking_type = 'zoo'
        AND user_id = :user_id;"
    );
    $stmt->execute(['user_id' => $user_id]);

    return (int) $stmt->fetchColumn();
}


?>

<?php
// Prevent direct browser access to this file
if (realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../frontend/signup.php');
    exit();
}
?>

