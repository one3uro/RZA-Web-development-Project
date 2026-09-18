<?php
include_once("../../database/connectdb.php");
include_once("../Backendfunctions/signupfunction.php");

$_errors = [];
$email = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic sanitization
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Call the backend function
    $result = registerUser($pdo, $email, $username, $password);

    if ($result['success']) {
        header("Location: login.php"); 
        exit(); 
    } else {
        // Grab the errors to display in the HTML below
        $_errors = $result['errors'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel=stylesheet href="../css/signup.css">
    <link rel="stylesheet" href="../css/footer.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RZA-Sign Up</title>
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
                    <span id="pageNumbers"></span>
                    <a href="#" class="next" id="nextBtn">Next ›</a>
                </div>
            </div>        
            <form method="POST" action="signup.php" class="form">
                <div class="title">
                    <h1 class="brand">RZA</h1>
                    <h1 class="sitename">Riget Zoo Adventures</h1>
                    <h2 class="welcome">Welcome to Riget Zoo Adventures</h2>
                </div>

                <!-- Email Field -->
                <div class="field">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required id="email" value="<?php echo htmlspecialchars($email); ?>">
                    <?php if (!empty($_errors['email'])): ?>
                        <span class="error-msg"><?php echo $_errors['email']; ?></span>
                        <?php endif; ?>
                    </div>
                <!-- Username Field -->
                <div class="field">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required id="username" value="<?php echo htmlspecialchars($username); ?>">
                    <?php if (!empty($_errors['username'])): ?>
                        <span class="error-msg"><?php echo $_errors['username']; ?></span>
                    <?php endif; ?>
                </div>
                <!-- Password Field -->
                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required id="password">
                    <?php if (!empty($_errors['password'])): ?>
                        <span class="error-msg"><?php echo $_errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <input class="submit" type="submit" name="submit" value="Sign Up">

                <p class="loginlink">Already have an account? <a href="login.php">Login</a></p>
            </form>
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