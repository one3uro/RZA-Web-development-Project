<?php
include_once("../../database/connectdb.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA - More Information</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/moreinfo.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <div class="browsercontainer">
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

        <div class="maincontainer">
            <div class="animals" id="animals">
                <h1>Animals</h1>
                <div class="picturedropdown">
                    <div class="image">
                        <img id="animal-img" src="../images/animals/lion.jpg" alt="Animal picture" />
                    </div>
                    <div class="dropdown">
                        <label for="animals-select">Choose an animal:</label>
                        <select name="animals" id="animals-select">
                            <option value="lion">Lion</option>
                            <option value="giraffe">Giraffe</option>
                            <option value="panda">Panda</option>
                            <option value="elephant">Elephant</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="animalinfo">
                     <h2 id="animal-title"></h2>
                    <p id="animal-desc"></p>
                </div>
            </div>

            <div class="newsletters" id="newsletters">
                <h1>Newsletters</h1>
                <h2>Meet Our Newest Arrival!</h2>    
                <p>We are thrilled to announce the birth of a healthy baby animal! Born just a few weeks ago, the little one is already exploring its habitat and staying close to mum.</p>
                <ul>
                    <li><strong>Where to look:</strong> You can spot them at the main habitat enclosure.</li>
                    <li><strong>Best viewing times:</strong> Early mornings are your best bet to see them active!</li>
                </ul>
                
                <h3>Upcoming Event: Twilight Safari Nights</h3>
                <p>Ever wondered what the zoo looks like after dark? Now is your chance to find out. Join us for our annual Twilight Safari Nights running every Friday next month.</p>
                <ul>
                    <li><strong>Highlights:</strong> Evening keeper talks, live music, and local food trucks.</li>
                    <li><strong>Tickets:</strong> Spaces are limited to keep the evening peaceful for our animals. Head over to our booking page to secure your slot.</li>
                </ul>

                <h3>Conservation Corner</h3>
                <p>Your visits make a real difference. A portion of every ticket sold this month goes directly toward funding wildlife tracking collars and supporting anti-poaching rangers in the wild. Thank you for helping us protect endangered species.</p>

                <h3>Quick Reminders</h3>
                <ul>
                    <li><strong>Members' Hour:</strong> The park opens an hour early at 8:00 AM this Saturday for all annual pass holders.</li>
                    <li><strong>Gift Shop Discount:</strong> Don't forget to flash your membership card for 10% off at the gift shop.</li>
                </ul>
            </div>

            <div class="about" id="about">
                <h2>About Us</h2>    
                <p>Welcome to Riget Zoo Adventures (RZA), a premier local attraction dedicated to bringing people closer to wildlife and nature. Founded with a passion for conservation and education, RZA has grown from a visionary wildlife park into a complete family destination. We are proud to offer an immersive, safari-style wildlife zoo featuring incredible animal exhibits, alongside an on-site hotel that allows guests to experience unforgettable overnight stays overlooking our habitats. From our very first days, providing engaging educational visits for schools and groups has been at the core of our mission, inspiring the next generation of wildlife protectors.</p>
                <p>To ensure our visitors enjoy the absolute best experience, we are currently working with a software development company to build an all-new digital platform. Driven by recent market research with our valued guests, this upcoming digital solution is designed entirely around your needs. The new website will provide comprehensive help and information about all our attractions and facilities while hosting interactive digital materials to support educational visits. Our upcoming platform will also feature a seamless booking engine where you can reserve zoo tickets and check availability for hotel stays. To thank our community, we are introducing a personal account registration system to help you effortlessly manage your bookings, alongside a brand-new loyalty and reward scheme. Most importantly, the entire system is being engineered with advanced accessibility features to ensure every single user can navigate our digital spaces easily. Whether you are planning a day on safari, booking an overnight getaway, or organizing a school trip, we look forward to welcoming you to the new era of RZA.</p>
            </div>

            <div class="contact" id="contact">
                <h2>Contact Us</h2>   
                <p>Thank you for your interest in Riget Zoo Adventures (RZA). Whether you are planning a day at our safari-style wildlife zoo, booking a stay at our on-site hotel, or organizing an educational visit, our team is here to help.</p>

                <h3>Get in Touch</h3>
                <ul>
                    <li><strong>General Enquiries &amp; Zoo Bookings:</strong> info@rigetzooadventures.com | 01632 960123</li>
                    <li><strong>Hotel Reservations:</strong> stay@rigetzooadventures.com | 01632 960456</li>
                    <li><strong>Education &amp; School Visits:</strong> education@rigetzooadventures.com | 01632 960789</li>
                    <li><strong>Digital Support &amp; Account Help:</strong> support@rigetzooadventures.com</li>
                </ul>

                <h3>Location &amp; Address</h3>
                <p>Riget Zoo Adventures — 100 Safari Park Way — Oakwood, OK1 4ZA</p>

                <h3>Opening Hours</h3>
                <ul>
                    <li><strong>Zoo Grounds:</strong> 9:00 AM – 5:00 PM daily (Last entry at 4:00 PM)</li>
                    <li><strong>Hotel Reception:</strong> 24 hours a day, 7 days a week</li>
                </ul>

                <p>You can also reach out to us by filling out our online contact form, and a member of our team will get back to you within 24 hours. We look forward to hearing from you!</p>
            </div>
        </div>
    </div>

    <script src="../javascript/animals.js"></script>

    <?php include(__DIR__ . "/footer.php" ); ?>
</body>
</html>