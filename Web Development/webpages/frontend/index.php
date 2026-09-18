<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel=stylesheet href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA-Homepage</title>
</head>
<body>
    <div class="universialcontainer">
        <div class="navbar">
            <ul>
                <li><a href="#news">Newsletters</a></li>
                <li><a href="#news">Book a Reservation</a></li>
                <li><a href="#contact">Contact Us</a><li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#news">Live map</a></li>
                <li><a href="#news">Animals</a></li>
                <li><a href="#news">Opening/Closing and Timings</a></li>
            </ul>
        </div>
        <div class="profilebar">
            <span class="welmsg">
                <span class="material-symbols-outlined">account_circle</span>
                Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!
            </span>
            <a href="#LR" class="lr-text">Loyalty Rewards</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <div class="maincontainer">
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
    </div>
    
    <?php include(__DIR__ . "/footer.php"); ?>

    <!--Image Slide show javascript function-->
    <script>
        const images = [
            "../images/image1.jpg",
            "../images/image2.jpg",
            "../images/image3.jpg",
            "../images/image4.jpg"
        ];

        let currentIndex = 0;

        const slideimg = document.getElementById("slideimg");
        const pageNumbers = document.getElementById("pageNumbers");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");

        function renderSlideshow() {
            slideimg.src = images[currentIndex];
            slideimg.classList.remove("fade");
            void slideimg.offsetWidth;
            slideimg.classList.add("fade");

            pageNumbers.innerHTML = "";
            images.forEach((img, i) => {
                const link = document.createElement("a");
                link.href = "#";
                link.textContent = i + 1;
                link.className = "page" + (i === currentIndex ? " active" : "");
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    currentIndex = i;
                    renderSlideshow();
                });
                pageNumbers.appendChild(link);
            });
        }

        prevBtn.addEventListener("click", (e) => {
            e.preventDefault();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            renderSlideshow();
        });

        nextBtn.addEventListener("click", (e) => {
            e.preventDefault();
            currentIndex = (currentIndex + 1) % images.length;
            renderSlideshow();
        });

        renderSlideshow();
    </script>
</body>
</html>