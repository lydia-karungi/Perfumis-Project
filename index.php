<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfumis</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <!-- Banner Image with November Discount -->
    <main>
        <div class="banner">
            <img src="perfume_images/dorrell-tibbs-jvgXFjwM0G4-unsplash.jpg" alt="banner">
            <div class="banner-content">
                <div class="discount-info">
                    <h2>Limited-Time Offer!</h2>
                    <p>Enjoy **10% off** on all fragrances this season. Indulge in luxury scents at unbeatable prices!</p>
                </div>
                <div class="cta">
                    <h1>Discover Your Signature Scent</h1>
                    <h2>Luxury, Elegance, and Timeless Fragrances</h2>
                    <p>Explore our exclusive collection of premium perfumes, perfect for every occasion. Whether you're searching for a bold new statement or a delicate everyday scent, we have something just for you.</p>
                    <a href="collections.php" class="cta-button">Shop Now</a>
                </div>
            </div>
        </div>

        <!-- Best Sellers -->
        <div class="section-header1">
            <h1>Best Sellers</h1>
        </div>

        <div class="content-container" id="best-sellers">
            <!-- Products will be dynamically inserted here -->
        </div>

        <!-- Shop by Category -->
        <div class="section-header2">
            <h1>Shop by Category</h1>
        </div>

        <div class="content-container" id="shop-by-category">
            <!-- Categories will be dynamically inserted here -->
        </div>

        <!-- What Are Customers Saying -->
        <div class="section-header2">
            <h1>What Are Customers Saying</h1>
        </div>


        <div class="review-carousel">
            <a class="carousel-control-prev" href="javascript:void(0);" id="prev">&#10094;</a>
            
            <div class="carousel-container" id="carousel-container">
                <div class="carousel-group" id="carousel-group">
                <!-- dynamically inserted .carousel-item elements -->
                </div>
            </div>
            
            <a class="carousel-control-next" href="javascript:void(0);" id="next">&#10095;</a>
        </div>

        <!-- Review Submission Form -->
   <!-- Review Submission Form -->
<div class="review-form-container">
    <h2>Leave a Review</h2>
    <form id="reviewForm">
        <input type="text" id="reviewerName" name="name" placeholder="Your name" required>
        
        <!-- Product Selector - will be populated dynamically -->
        <select id="reviewProduct" name="product_id" required>
            <option value="">Which product are you reviewing?</option>
            <!-- Options will be loaded dynamically from database -->
        </select>
        
        <div class="rating-input">
            <label for="reviewRating">Rating:</label>
            <select id="reviewRating" name="rating" required>
                <option value="">Select rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent (5/5)</option>
                <option value="4">⭐⭐⭐⭐☆ Very Good (4/5)</option>
                <option value="3">⭐⭐⭐☆☆ Good (3/5)</option>
                <option value="2">⭐⭐☆☆☆ Fair (2/5)</option>
                <option value="1">⭐☆☆☆☆ Poor (1/5)</option>
            </select>
        </div>
        
        <textarea id="reviewText" name="review" rows="4" placeholder="Tell us about your experience with this fragrance..." required></textarea>
        <button type="submit">Submit Review</button>
        <div class="feedback" id="reviewFeedback"></div>
    </form>
</div>
    </main>

    <script src="js/script.js"></script>
    <!-- Footer -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>

</html>
