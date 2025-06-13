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
    <title>About Us | Perfumis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>

<body style="padding-top: 0 !important;">
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main style="padding-top: 140px;">
        <!-- About Banner -->
        <div style="
            position: relative;
            width: 100%;
            height: 50vh;
            max-height: 400px;
            margin: 0 auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(191, 46, 26, 0.3)), url('perfume_images/laura-chouette-gbT2KAq1V5c-unsplash_resized.jpeg') center/cover;
        ">
            <div style="
                position: relative;
                z-index: 10;
                text-align: center;
                color: white;
                padding: 40px 20px;
                max-width: 800px;
            ">
                <h1 style="
                    font-family: 'Dancing Script', cursive;
                    font-size: 3.5rem;
                    font-weight: 700;
                    margin-bottom: 20px;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                ">About Perfumis</h1>
                <p style="
                    font-size: 1.2rem;
                    line-height: 1.6;
                    margin-bottom: 15px;
                    color: white;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
                    font-family: 'Nunito', sans-serif;
                ">Discover the art of fragrance with Perfumis, where every scent tells a story and every bottle holds a moment of pure luxury.</p>
                <p style="
                    font-size: 1.2rem;
                    line-height: 1.6;
                    margin-bottom: 15px;
                    color: white;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
                    font-family: 'Nunito', sans-serif;
                ">We are passionate about bringing you the finest collection of premium fragrances from around the world.</p>
            </div>
        </div>

        <!-- Our Mission Section -->
        <div style="padding: 80px 0; background: #fff;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <div style="text-align: center; margin-bottom: 60px;">
                    <h2 style="
                        font-family: 'Dancing Script', cursive;
                        font-size: 3rem;
                        color: #bf2e1a;
                        margin-bottom: 15px;
                        font-weight: 600;
                    ">Our Mission & Vision</h2>
                    <p style="
                        font-size: 1.1rem;
                        color: #666;
                        max-width: 600px;
                        margin: 0 auto;
                        line-height: 1.6;
                    ">At Perfumis, we believe that fragrance is more than just a scent – it's an expression of personality, a creator of memories, and a bridge to emotions.</p>
                </div>
                
                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 40px;
                    margin-top: 40px;
                ">
                    <div style="
                        background: white;
                        padding: 40px 30px;
                        border-radius: 15px;
                        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        transition: all 0.3s ease;
                        border: 1px solid #e0e0e0;
                        position: relative;
                        overflow: hidden;
                        border-top: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(191, 46, 26, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1)'">
                        <i class="fas fa-heart" style="
                            font-size: 3rem;
                            color: #bf2e1a;
                            margin-bottom: 20px;
                            display: block;
                        "></i>
                        <h3 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.5rem;
                            color: #333;
                            margin-bottom: 15px;
                            font-weight: 600;
                        ">Our Mission</h3>
                        <p style="
                            color: #666;
                            line-height: 1.6;
                            font-size: 1rem;
                        ">To curate and deliver the world's most exquisite fragrances, helping you discover your signature scent that reflects your unique personality and style. We are committed to providing exceptional quality and service in every interaction.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 40px 30px;
                        border-radius: 15px;
                        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        transition: all 0.3s ease;
                        border: 1px solid #e0e0e0;
                        position: relative;
                        overflow: hidden;
                        border-top: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(191, 46, 26, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1)'">
                        <i class="fas fa-eye" style="
                            font-size: 3rem;
                            color: #bf2e1a;
                            margin-bottom: 20px;
                            display: block;
                        "></i>
                        <h3 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.5rem;
                            color: #333;
                            margin-bottom: 15px;
                            font-weight: 600;
                        ">Our Vision</h3>
                        <p style="
                            color: #666;
                            line-height: 1.6;
                            font-size: 1rem;
                        ">To become the leading destination for fragrance enthusiasts worldwide, creating a community where the art of perfumery is celebrated and where every customer finds their perfect scent match.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story Section -->
        <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 100px 0;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 60px;
                    align-items: center;
                " id="storyGrid">
                    <div>
                        <h3 style="
                            font-family: 'Dancing Script', cursive;
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 20px;
                        ">Our Story</h3>
                        <p style="
                            font-size: 1.1rem;
                            line-height: 1.7;
                            color: #555;
                            margin-bottom: 20px;
                        ">Perfumis was born from a passion for the artistry and craftsmanship of fine fragrances. What started as a love affair with scents has evolved into a carefully curated collection of the world's most beautiful perfumes.</p>
                        
                        <p style="
                            font-size: 1.1rem;
                            line-height: 1.7;
                            color: #555;
                            margin-bottom: 20px;
                        ">Our journey began with the simple belief that everyone deserves to experience the transformative power of the perfect fragrance. Today, we continue to search the globe for exceptional scents that capture the essence of luxury and elegance.</p>
                        
                        <p style="
                            font-size: 1.1rem;
                            line-height: 1.7;
                            color: #555;
                            margin-bottom: 20px;
                        ">From rare niche fragrances to beloved classics, every bottle in our collection has been selected with care and consideration for the discerning fragrance lover.</p>
                    </div>
                    
                    <div style="
                        position: relative;
                        border-radius: 15px;
                        overflow: hidden;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                    ">
                        <img src="perfume_images/gift-habeshaw-C1qrJ9i4EPc-unsplash.jpg" alt="Perfume collection" style="
                            width: 100%;
                            height: 400px;
                            object-fit: cover;
                        " onerror="this.style.display='none'">
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Values Section -->
        <div style="padding: 80px 0; background: #fff;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <div style="text-align: center; margin-bottom: 60px;">
                    <h2 style="
                        font-family: 'Dancing Script', cursive;
                        font-size: 3rem;
                        color: #bf2e1a;
                        margin-bottom: 15px;
                        font-weight: 600;
                    ">Our Values</h2>
                    <p style="
                        font-size: 1.1rem;
                        color: #666;
                        max-width: 600px;
                        margin: 0 auto;
                        line-height: 1.6;
                    ">These core principles guide everything we do at Perfumis</p>
                </div>
                
                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 30px;
                    margin-top: 50px;
                " id="valuesGrid">
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-gem" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Quality Excellence</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">We source only the finest fragrances from renowned perfumers and trusted brands, ensuring every product meets our high standards.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-users" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Customer First</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">Your satisfaction is our priority. We provide personalized service and expert guidance to help you find your perfect scent.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-leaf" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Sustainability</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">We are committed to responsible sourcing and supporting brands that prioritize environmental consciousness and ethical practices.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-palette" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Artistry</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">We celebrate the art of perfumery and the master perfumers who create these olfactory masterpieces that inspire and delight.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-shipping-fast" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Reliability</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">From secure packaging to timely delivery, we ensure your fragrance journey with us is smooth and worry-free.</p>
                    </div>
                    
                    <div style="
                        background: white;
                        padding: 30px 25px;
                        border-radius: 12px;
                        text-align: center;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                        transition: all 0.3s ease;
                        border-left: 4px solid #bf2e1a;
                    " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(191, 46, 26, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.08)'">
                        <i class="fas fa-star" style="
                            font-size: 2.5rem;
                            color: #bf2e1a;
                            margin-bottom: 15px;
                        "></i>
                        <h4 style="
                            font-family: 'Noto Serif', serif;
                            font-size: 1.3rem;
                            color: #333;
                            margin-bottom: 10px;
                        ">Excellence</h4>
                        <p style="
                            color: #666;
                            line-height: 1.5;
                            font-size: 0.95rem;
                        ">We strive for excellence in every aspect of our service, from product curation to customer experience and beyond.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div style="
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            padding: 80px 0;
            text-align: center;
        ">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <h2 style="
                    font-family: 'Dancing Script', cursive;
                    font-size: 3rem;
                    margin-bottom: 20px;
                ">Ready to Find Your Signature Scent?</h2>
                <p style="
                    font-size: 1.2rem;
                    margin-bottom: 30px;
                    max-width: 600px;
                    margin-left: auto;
                    margin-right: auto;
                ">Explore our carefully curated collection of premium fragrances and discover the perfect scent that speaks to your soul.</p>
                <a href="collections.php" style="
                    display: inline-block;
                    padding: 15px 40px;
                    background: white;
                    color: #bf2e1a;
                    text-decoration: none;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 1.1rem;
                    transition: all 0.3s ease;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                " onmouseover="this.style.background='#f8f9fa'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.background='white'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">Shop Our Collection</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="js/header.js"></script>
    
    <script>
        // Mobile responsive adjustments
        function adjustForMobile() {
            if (window.innerWidth <= 768px) {
                // Adjust story grid for mobile
                const storyGrid = document.getElementById('storyGrid');
                if (storyGrid) {
                    storyGrid.style.gridTemplateColumns = '1fr';
                    storyGrid.style.gap = '40px';
                }
                
                // Adjust banner title size
                const bannerTitle = document.querySelector('main h1');
                if (bannerTitle) {
                    bannerTitle.style.fontSize = '2.5rem';
                }
            }
        }
        
        // Run on page load and resize
        window.addEventListener('load', adjustForMobile);
        window.addEventListener('resize', adjustForMobile);
    </script>
</body>

</html>