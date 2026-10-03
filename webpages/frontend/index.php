<?php
include_once("../../database/connectdb.php");
include_once("../Backendfunctions/reservations.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}   

$message = '';
$toastClass = '';

// Triggered when the user submits the form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserve_submit'])) {
    
    // 1. Fetch user ID from session or database
    $user_id = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;

    if (!$user_id && isset($_SESSION['email'])) {
        $stmt = $pdo->prepare("SELECT id FROM signupform WHERE email = :email");
        $stmt->execute([':email' => $_SESSION['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['id'] ?? null;
        $_SESSION['user_id'] = $user_id; // Save to session for the payment page
    }

    // 2. Save reservation temporarily to SESSION instead of database
    if ($user_id) {
        $_SESSION['pending_reservation'] = $_POST;
        header("Location: payment.php");
        exit();
    } else {
        $message = "User session invalid. Please log in again.";
        $toastClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA-Homepage</title>
</head>
<body>
    <div class="universialcontainer">
        <div class="header">

            <!-- Navigation Bar -->
            <div class="navbar">
                <ul>
                    <li><a href="moreinfo.php">Newsletters</a></li>
                    <li><a href="moreinfo.php">Book a Reservation</a></li>
                    <li><a href="moreinfo.php">Contact Us</a></li>
                    <li><a href="moreinfo.php">About Us</a></li>
                    <li><a href=index.php#map>Live map</a></li>
                    <li><a href="moreinfo.php#animals">Animals</a></li>
                    <li><a href="index.php#timings">Opening/Closing and Timings</a></li>
                </ul>
            </div>

            <h1 class="title">Welcome to Riget Zoo Adventures</h1>

            <div class="profilebar">
                <span class="welmsg">
                    <span class="material-symbols-outlined">account_circle</span>
                    Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!
                </span>
                <a href="profile.php" class="lr-text">Loyalty Rewards</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
        
        <!-- Live Map Slideshow Section -->
        <div class="maincontainer" id="map">   
            <div class="homeslideshow">
                <div class="slide">
                    <img src="" alt="Zoo photo" class="slideimg" id="slideimg">
                </div>
                <div class="pagination" id="pagination">
                    <a href="#" class="prev" id="prevBtn">‹ Previous</a>
                    <span id="pageNumbers"></span>
                    <a href="#" class="next" id="nextBtn">Next ›</a>
                </div>
            </div>
        </div>

        <div class="externalmap">
            <div class="mapcontainer">
                <h2 class="mapheading">Find your way around using the Live Map.</h2>
                <iframe 
                    width="100%" 
                    height="100%" 
                    style="border:0" 
                    loading="lazy" 
                    allowfullscreen 
                    src="https://maps.google.com/maps?q=London%20Zoo&t=&z=13&ie=UTF8&iwloc=&output=embed">
                </iframe>
            </div>
        </div>

        <!-- Container-Group1 -->
        <div class="containergroup">   

            <div class="l-t-e">
                <img class = "image" src="../images/homepageimages/cardimages/lte.jpg" alt="Banner" style="width:100%">
                <div class="card-containe1">
                    <h4 class="cardtitle"><b>Limited Time Events</b></h4>
                    <p class="cardtitle"><strong>Currently Running:</strong></p>
                    <ul>
                        <li>Penguin Feeding Encounter — Daily, 11:00 AM & 3:00 PM, Ice Kingdom exhibit</li>
                        <li>Glacier Trail Photo Safari — Now through end of month, self-guided</li>
                        <li>Keeper Talk: Life of a Polar Bear — Daily, 1:30 PM, Arctic Zone</li>
                        <li>Summer Late Nights — Fri–Sat, park open until 8:00 PM</li>
                    </ul>
                </div>
            </div>

            <div class="l-and-e">
                <img class = "image" src="../images/homepageimages/cardimages/l-and-e.jpg" alt="Banner" style="width:100%">
                <div class="card-container2">
                    <h4 class="cardtitle"><b>Learning and Education</b></h4>
                    <p class="cardtitle"><strong>Currently Running:</strong></p>
                    <ul>
                        <li>10:00 AM - Lion Lookout: Learn how our pride rules the savanna and what it takes to feed a 400-pound king</li>
                        <li>Penguin Plunge: Watch the colony dive for their lunch while discovering how these birds stay warm in South Africa.</li>
                        <li>Reptile Rendezvous: Get up close with our cold-blooded residents and bust the most common myths about snakes.</li>
                        <li>Elephant Enclosure: Discover the incredible communication methods elephants use to talk across miles of wilderness.</li>
                    </ul>
                </div>
            </div>

            <div class="availability">
                <img class = "image" src="../images/homepageimages/cardimages/availability.jpg" alt="Banner" style="width:100%">
                <div class="card-container3">
                    <h4 class="cardtitle"><b>Availability</b></h4>
                    <p class="cardtitle"><strong>Currently Available:</strong></p>
                    <ul>
                        <li>Standard Queen Room: Available (2 rooms left at £120/night)</li>
                        <li>Deluxe King Room: Fully Booked (Waitlist available)</li>
                        <li>Executive Suite: Available (1 room left at £285/night)</li>
                        <li>Accessible Twin Room: Available (4 rooms left at £110/night)</li>
                    </ul>
                </div>
            </div>

            <div class="timings" id="timings">
                <img class = "image" src="../images/homepageimages/cardimages/timings.jpg" alt="Banner" style="width:100%">
                <div class="card-container4"> 
                    <h4 class="cardtitle"><b>Timings</b></h4>
                    <p class="cardtitle"><strong>Time Schedule</strong></p>
                    <ul>
                        <li>Resort Reception: open 24/7 for overnight lodge guest check-in and support.</li>
                        <li>Safari Drive-Through: open 09:00 - 17:00 (last vehicle entry strictly at 16:00).</li>
                        <li>Walking Foot Safari: open 09:30 - 16:30 (animal houses close at 16:00).</li>
                        <li>Guided Truck Tours: running 10:00 - 16:30 (expeditions depart every 20 minutes).</li>
                        <li>Giraffe Feeding Platform: open 11:00 - 12:30 for morning public encounter sessions</li>
                    </ul>
                </div>
            </div>

            <div class="pricing">
                <img class = "image" src="../images/homepageimages/cardimages/pricing.jpg" alt="Banner" style="width:100%">
                <div class="card-container5">
                    <h4 class="cardtitle"><b>Pricing</b></h4>
                    <p class="cardtitle"><strong>Currently Running:</strong></p>
                    <ul>
                        <li>Twin Room = £50/night</li>
                        <li>Deluxe King Room = £55/night</li>
                        <li>Standard Queen Room = £45/night</li>
                        <li>Executive Suite = £25/night</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="reservationcontainer" id="reservations">
            <form method="POST" action="" class="booking-form">  
                <!-- Header & Top Dropdown -->
                 <div class="form-header">
                    <h2 class="form-title"><u>Bookings:</u></h2>
                    <div class="field-inline">
                        <label for="booking_type">Hotel/ticket:</label>
                        <select name="booking_type" id="booking_type" onchange="toggleBookingType()" required>
                            <option value="" disabled selected>Select Dropdown</option>
                            <option value="hotel">Hotel Reservation</option>
                            <option value="zoo">Zoo Ticket</option>
                        </select>
                    </div>
                </div>

                <?php if (!empty($message)): ?>
                    <p class="error-toast <?php echo $toastClass; ?>"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <div class="form-grid">
                    <!-- LEFT COLUMN -->
                    <div class="form-col">
                        <div class="field">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="e.g. John S. Lakeman" required>
                        </div>

                        <div class="field">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" 
                                placeholder="e.g. John.Lakeman@gmail.com" 
                                value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>
                        </div>

                        <div class="field">
                            <label for="date">Date:</label>
                            <input type="date" name="date" id="date" required>
                        </div>

                        <!-- HOTEL ONLY FIELD -->
                        <div class="field dynamic-field" id="field_room" style="display: none;">
                            <label for="room_type">Select Room:</label>
                            <select name="room_type" id="room_type" onchange="calculateTotal()">
                                <option value="" disabled selected>Select Dropdown</option>
                                <option value="120">Standard Queen Room (£120/night)</option>
                                <option value="50">Twin Room (£50/night)</option>
                                <option value="150">Deluxe King Room (£150/night)</option>
                                <option value="285">Executive Suite (£285/night)</option>
                                <option value="110">Accessible Twin Room (£110/night)</option>
                            </select>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="form-col">
                        <!-- ZOO TICKET ONLY FIELD -->
                        <div class="field dynamic-field" id="field_time" style="display: none;">
                            <label for="time">Time:</label>
                            <select name="time" id="time">
                                <option value="" disabled selected>e.g. 3:52</option>
                                <option value="09:30">09:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="13:30">01:30 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:30">04:30 PM</option>
                            </select>
                        </div>

                        <!-- ZOO TICKET ONLY FIELD -->
                        <div class="field dynamic-field" id="field_ticket_amount" style="display: none;">
                            <label for="ticket_amount">Ticket amount:</label>
                            <select name="ticket_amount" id="ticket_amount" onchange="calculateTotal()">
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6+</option>
                            </select>
                        </div>

                        <!-- HOTEL ONLY FIELD -->
                        <div class="field dynamic-field" id="field_people_amount" style="display: none;">
                            <label for="people_amount">People amount:</label>
                            <select name="people_amount" id="people_amount">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                                <option value="5">5+</option>
                            </select>
                        </div>

                        <!-- TOTAL AMOUNT DISPLAY -->
                        <div class="field total-field">
                            <label for="total_amount">Total Amount:</label>
                            <div class="price-input-wrapper">
                                <span class="currency-symbol">£</span>
                                <input type="text" name="total_amount" id="total_amount" value="0.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                 <div class="form-actions">
                    <button type="submit" name="reserve_submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

    
    <?php include(__DIR__ . "/footer.php" ); ?>
 
    <!-- Image Slideshow JavaScript Function -->
    <script src="../javascript/index.js"></script>
    <script src="../javascript/reservations.js"></script> 
</body> 
</html>