<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Nunito:wght@300;400;500;600;700&family=Noto+Serif:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS files in correct order -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <div class="header-container">
        <!-- Hamburger Menu Button -->
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!--Main menu-->
        <div class="main-menu">
            <div class="logo">
                <a href="index.php">Perfumis</a>
            </div>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                <li>
                    <a href="cart.php" class="cart-link">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="cart-counter" id="cartCounter">0</span>
                    </a>
                </li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.html"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!--Navigation bar-->
        <nav class="nav-bar">
            <div class="nav-bar-container">
                <ul>
                    <li><a href="collections.php">Our Shop</a>
                        <ul class="dropdown">
                            <li><a href="collections.php?category=men"><i class="fas fa-male"></i> Men's Fragrances</a></li>
                            <li><a href="collections.php?category=women"><i class="fas fa-female"></i> Women's Fragrances</a></li>
                            <li><a href="collections.php?category=unisex"><i class="fas fa-users"></i> Unisex Fragrances</a></li>
                            <li><a href="collections.php?category=luxury"><i class="fas fa-crown"></i> Luxury Collection</a></li>
                        </ul>
                    </li>
                    <li><a href="collections.php">Collections</a></li>
                    <li><a href="gifts.php">Gifts</a>
                        <ul class="dropdown">
                            <li><a href="gifts.php?category=her"><i class="fas fa-gift"></i> Gifts for Her</a></li>
                            <li><a href="gifts.php?category=him"><i class="fas fa-gift"></i> Gifts for Him</a></li>
                            <li><a href="gifts.php?category=wedding"><i class="fas fa-heart"></i> Wedding Gifts</a></li>
                            <li><a href="gifts.php?category=sets"><i class="fas fa-box"></i> Gift Sets</a></li>
                        </ul>
                    </li>
                    <li><a href="collections.php?new=true">New Arrivals</a></li>
                    <li><a href="brands.php">Brands</a>
                        <ul class="dropdown">
                            <li><a href="brands.php?brand=dior"><i class="fas fa-star"></i> Dior</a></li>
                            <li><a href="brands.php?brand=chanel"><i class="fas fa-star"></i> Chanel</a></li>
                            <li><a href="brands.php?brand=gucci"><i class="fas fa-star"></i> Gucci</a></li>
                            <li><a href="brands.php?brand=armani"><i class="fas fa-star"></i> Armani</a></li>
                            <li><a href="brands.php?brand=tomford"><i class="fas fa-star"></i> Tom Ford</a></li>
                        </ul>
                    </li>
                    <li><a href="accessories.php">Accessories</a></li>
                    <li><a href="samples.php">Samples</a>
                        <ul class="dropdown">
                            <li><a href="samples.php?type=samples"><i class="fas fa-vial"></i> Perfume Samples</a></li>
                            <li><a href="samples.php?type=travel"><i class="fas fa-plane"></i> Travel Sprays</a></li>
                            <li><a href="samples.php?type=storage"><i class="fas fa-box"></i> Storage</a></li>
                        </ul>
                    </li>
                    <li><a href="scent-quiz.php">Scent Quiz</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Scroll to top button -->
    <button class="scroll-to-top" id="scrollToTop" style="display: none;">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Load header functionality -->
    <script src="js/header.js"></script>
</body>
</html>