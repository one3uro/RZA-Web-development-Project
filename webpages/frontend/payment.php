<?php
session_start();
include_once("../../database/connectdb.php");
include_once("../Backendfunctions/reservations.php");


$user_id = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;

if (!$user_id && isset($_SESSION['email'])) {
    $stmt = $pdo->prepare("SELECT id FROM signupform WHERE email = :email");
    $stmt->execute([':email' => $_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['id'] ?? null;
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
    }
}

$res_data = $_SESSION['pending_reservation'] ?? null;

// 2. Trigger database insert when "Pay" is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_submit'])) {
    if ($user_id && $res_data) {
        $success = createReservation($pdo, $res_data, $user_id);
        if ($success) {
            // Add loyalty points if you implemented the helper function
            if (function_exists('addLoyaltyPoints')) {
                $amount_spent = (float)($res_data['total_amount'] ?? 0);
                addLoyaltyPoints($pdo, $user_id, $amount_spent);
            }

            unset($_SESSION['pending_reservation']); // Clear session data
            echo "<script>alert('Payment Successful! Reservation saved.'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error saving reservation.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/payment.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <div class="universial">
        <div class="main">

            <div class="group1">
                <div class="greetings">
                    <span>
                        Hi,Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!
                    </span>
                </div>
                <div class="gapay">
                    <div class="google">
                        <button class="gpay-dummy" onclick="alert('Google Pay clicked (Dummy Integration)')">
                            <span class="gpay-icon"></span>
                            <span class="gpay-text">Pay</span>
                        </button>
                    </div>
                    <div class="apple">
                        <button class="applepay-dummy" onclick="alert('Apple Pay clicked (Dummy Integration)')"></button>
                    </div>
                </div>

                <div class="cardcontainer">
                    <div class="payment-row">
                        <div class="payment-icon icon-card">
                            <div class="icon-card-inner"></div>
                        </div>
                        <div class="payment-details">
                            <p class="payment-title">Card</p>
                            <div class="card-brands">
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                                <div class="brand"></div>
                            </div>
                        </div>
                        <div class="radio-circle"></div>
                    </div>

                    <div class="payment-row">
                        <div class="payment-icon icon-ideal">
                            <strong>i</strong>DEAL
                        </div>
                        <div class="payment-details">
                            <p class="payment-title">iDEAL</p>
                        </div>
                        <div class="radio-circle"></div>
                    </div>

                    <div class="payment-row">
                        <div class="payment-icon icon-klarna">K.</div>
                        <div class="payment-details">
                            <p class="payment-title">Pay later.</p>
                        </div>
                        <div class="radio-circle"></div>
                    </div>

                    <div class="payment-row">   
                        <div class="payment-icon icon-sofort">SOFORT</div>
                        <div class="payment-details">
                            <p class="payment-title">Sofort</p>
                        </div>
                        <div class="radio-circle"></div>
                    </div>
                </div>
                <div class="email">
                    <h2>Personal Information</h2>
                    <span>
                      Username: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>, Email: <?php echo htmlspecialchars($_SESSION['email'] ?? 'Guest@handle.com'); ?>
                    </span>
                </div>

                <form method="POST" action="" style="width: 100%; display: flex; justify-content: center;">
                    <button type="submit" name="pay_submit" class="pay">Pay £<?php echo htmlspecialchars($res_data['total_amount'] ?? '0.00'); ?></button>
                </form>
            </div>

            <div class="group2">
                <div class="summary">
                    <h1 class="summary">Summary</h2>
                    <?php if ($res_data): ?>
                        <div style="margin-bottom: 20px;">
                            <?php if ($res_data['booking_type'] === 'hotel'): ?>
                                <p style="display: flex; justify-content: space-between; margin: 0;">
                                    <span>Hotel Booking</span>
                                </p>
                                <p style="color: gray; font-size: 14px; margin: 5px 0;">
                                    Quantity 1 • Guests: <?php echo htmlspecialchars($res_data['people_amount'] ?? '1'); ?>
                                </p>
                            <?php elseif ($res_data['booking_type'] === 'zoo'): ?>
                                <p style="display: flex; justify-content: space-between; margin: 0;">
                                    <span>Zoo Ticket (<?php echo htmlspecialchars($res_data['time'] ?? 'Anytime'); ?>)</span>
                                </p>
                                <p style="color: gray; font-size: 14px; margin: 5px 0;">
                                    Quantity <?php echo htmlspecialchars($res_data['ticket_amount'] ?? '1'); ?>
                                </p>
                            <?php endif; ?>
                            <p style="color: gray; font-size: 14px; margin: 5px 0;">
                                Date: <?php echo htmlspecialchars($res_data['date'] ?? ''); ?>
                            </p>
                        </div>

                        <hr style="border-top: 1px solid #ccc; margin: 20px 0;">
                        
                        <p style="display: flex; justify-content: space-between; font-weight: bold;">
                            <span>Total order amount</span>
                            <span>£<?php echo htmlspecialchars($res_data['total_amount'] ?? '0.00'); ?></span>
                        </p>
                    <?php else: ?>
                        <p class="reservationmsg">No reservation data found.</p>
                    <?php endif; ?>
                </div> 
            </div>

        </div>

    </div>

    
    
    
</body>
</html>