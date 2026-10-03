<?php
include_once("../../database/connectdb.php");
include_once("../Backendfunctions/authentication.php");

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Call the backend function
    $result = resetUserPassword($pdo, $email, $password, $confirmPassword);
    
    // Always map the message and toast class to display in the UI
    $message = $result['message'];
    $toastClass = $result['toastClass'];

    // If successful, trigger the frontend redirect
    if ($result['success']) {
        header("refresh:2;url=login.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel=stylesheet href="../css/resetpassword.css">
    <link rel="stylesheet" href="../css/footer.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA-Reset Password</title>
</head>
<body>
    <div class="universialcontainer">
        <div class="topnav">
            <a href="index.php">Newsletters</a>
            <a href="index.php">Book a reservation</a>
            <a href="index.php">Contact us</a>
            <a href="index.php">About us</a>
        </div>
        <div class="maincontainer">
            <div class="imagecontainer">
                <div class="slide">
                    <img src="" alt="Zoo photo" class="slideimg" id="slideimg">
                </div>
                <div class="pagination" id="pagination">
                    <a href="#" class="prev" id="prevBtn">‹ Previous</a>
                    <span    id="pageNumbers"></span>
                    <a href="#" class="next" id="nextBtn">Next ›</a>
                </div>
            </div>        
            <form method="POST" action="resetpassword.php" class="form">
                <div class="title">
                    <h1 class="brand">RZA</h1>
                    <h1 class="sitename">Riget Zoo Adventures</h1>
                    <h2 class="welcome">Reset Your Password</h2>
                </div>

                <?php if (!empty($message)): ?>
                    <p class="error-toast <?php echo $toastClass; ?>"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <div class="field">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field">
                    <label for="password">New Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="field">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>

                <input class="submit" type="submit" name="submit" value="Reset Password">
                <p class="loginlink">Remembered your password? <a href="login.php">Login</a></p>
                <p class="loginlink">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>

    <?php include(__DIR__ . "/footer.php"); ?>

    <!--Image Slideshow JavaScript-->
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