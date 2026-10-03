<?php

function createReservation($pdo, $formData, $user_id) {
    try {
        // 1. Sanitize and Extract Core Form Fields
        $booking_type  = $formData['booking_type'] ?? null;
        $booking_date  = $formData['date'] ?? null;
        
        $booking_time  = !empty($formData['time']) ? $formData['time'] : '00:00:00';
        
        $people_amount = filter_var($formData['people_amount'] ?? 0, FILTER_VALIDATE_INT);
        $total_amount  = filter_var($formData['total_amount'] ?? 0.00, FILTER_VALIDATE_FLOAT);

        // 2. Conditional Form Expansion Logic
        $room_type     = null;
        $ticket_amount = null;

        if ($booking_type === 'hotel') {

            $room_mapping = [
                '120' => 'Standard Queen Room',
                '50'  => 'Twin Room',
                '150' => 'Deluxe King Room',
                '285' => 'Executive Suite',
                '110' => 'Accessible Twin Room'
            ];
            $submitted_room_val = $formData['room_type'] ?? null;
            $room_type = $room_mapping[$submitted_room_val] ?? $submitted_room_val;
            
        } elseif ($booking_type === 'zoo') {
            $ticket_amount = filter_var($formData['ticket_amount'] ?? 0, FILTER_VALIDATE_INT);
        }

        // 3. Prepare the SQL Statement
        $sql = "INSERT INTO reservations (
                    user_id, booking_type, booking_date, booking_time, 
                    room_type, ticket_amount, people_amount, total_amount
                ) VALUES (
                    :user_id, :booking_type, :booking_date, :booking_time, 
                    :room_type, :ticket_amount, :people_amount, :total_amount
                )";

        $stmt = $pdo->prepare($sql);

        // 4. Execute and Insert into Database
        return $stmt->execute([
            ':user_id'       => $user_id,
            ':booking_type'  => $booking_type,
            ':booking_date'  => $booking_date,
            ':booking_time'  => $booking_time,
            ':room_type'     => $room_type,
            ':ticket_amount' => $ticket_amount,
            ':people_amount' => $people_amount,
            ':total_amount'  => $total_amount
        ]);

    } catch (PDOException $e) {
        // Log the error message 
        error_log("Booking Error: " . $e->getMessage());
        return false;
    }
}

function addLoyaltyPoints($pdo, $user_id, $amount) {
    try {
        // £1 = 1 point (convert total amount to whole points)
        $points_earned = (int) floor((float)$amount);

        if ($points_earned > 0) {
            $stmt = $pdo->prepare("UPDATE signupform SET loyalty_points = COALESCE(loyalty_points, 0) + :points WHERE id = :user_id");
            return $stmt->execute([
                ':points'  => $points_earned,
                ':user_id' => $user_id
            ]);
        }
        return false;
    } catch (PDOException $e) {
        error_log("Loyalty Points Error: " . $e->getMessage());
        return false;
    }
}

?>

<?php
// Prevent direct browser access to this file
if (realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: ../frontend/signup.php');
    exit();
}
?>