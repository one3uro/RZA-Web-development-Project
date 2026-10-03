<?php
session_start();
include_once("../../database/connectdb.php");
include_once("../Backendfunctions/loyalty.php");
include_once("../Backendfunctions/total_zoo_and_reservations.php");


if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loyaltyPoints = getLoyaltyPoints($pdo, $_SESSION['user_id']);
$totalhotel = totalBookings($pdo, $_SESSION['user_id']);
$totalzoo = totalticket($pdo, $_SESSION['user_id']);

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA-Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <div class="universialcontainer">
        <div class="header">
            <div class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="moreinfo.php#animals">Animals</a></li>
                    <li><a href="moreinfo.php#newsletters">Newsletters</a></li>
                    <li><a href="moreinfo.php#about">About Us</a></li>
                    <li><a href="moreinfo.php#contact">Contact Us</a></li>
                    <li><a href="index.php#reservations">Bookings</a></li>
                </ul>
            </div>

            <h1 class="title">Riget Zoo Adventures</h1>

            <div class="profilebar">
                <span class="welmsg">
                    <span class="material-symbols-outlined">account_circle</span>
                    Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!
                </span>
                <a href="profile.php" class="lr-text">Loyalty Rewards</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <div class="profile-container">
            <div class="profile-info">
                <h2>Profile Information</h2>
                <p class="puser"><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username'] ?? 'N/A'); ?></p>
                <p class="pemail"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                <p class="pbookings"><strong>Total Hotel Bookings:</strong><?php echo $totalhotel; ?></p>
                <p class="pzoo"><strong>Total Zoo Bookings:</strong><?php echo $totalzoo; ?></p>
                <p class="loyalty-points">Loyalty points: <?php echo $loyaltyPoints; ?></p>
            </div>
            <div class="profileimage">
                <image>dummy image here</image>
            </div>
        </div>
    </div>
    <?php include(__DIR__ . "/footer.php"); ?>
</body>
</html>