<?php
function getLoyaltyPoints(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare("SELECT loyalty_points FROM signupform WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    return (int) ($stmt->fetchColumn() ?: 0);
}

function calculatePointsEarned(float $amountPaid): int {
    // 1 point per £1 spent.
    return (int) floor($amountPaid);
}

function addLoyaltyPoints(PDO $pdo, int $userId, int $points): bool {
    if ($points <= 0) return false;
    // Adds inside the database itself, so two purchases at once can't overwrite each other
    $stmt = $pdo->prepare(
        "UPDATE signupform SET loyalty_points = loyalty_points + :pts WHERE id = :id"
    );
    return $stmt->execute([':pts' => $points, ':id' => $userId]);
}

function spendLoyaltyPoints(PDO $pdo, int $userId, int $points): bool {
    if ($points <= 0) return false;
    // The "AND loyalty_points >= :pts" check stops the balance going negative
    $stmt = $pdo->prepare(
        "UPDATE signupform SET loyalty_points = loyalty_points - :pts
         WHERE id = :id AND loyalty_points >= :pts"
    );
    $stmt->execute([':pts' => $points, ':id' => $userId]);
    return $stmt->rowCount() === 1;
}
?>

<?php
// Prevent direct browser access to this file
if (realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../frontend/signup.php');
    exit();
}
?>