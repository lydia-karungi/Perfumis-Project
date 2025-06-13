<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us | Perfumis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main style="padding-top: 140px;">
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
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(191, 46, 26, 0.3)), url('perfume_images/banner2.jpg') center/cover;
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
                ">Contact Us</h1>
                <p style="
                    font-size: 1.2rem;
                    line-height: 1.6;
                    color: white;
                    font-family: 'Nunito', sans-serif;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
                ">We would love to hear from you. Whether you have a question about our fragrances, need assistance, or just want to share your experience, our team is here to help.</p>
            </div>
        </div>

        <div style="padding: 80px 0; background: #fff;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; gap: 40px; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                <div style="
                    background: white;
                    padding: 40px 30px;
                    border-radius: 15px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                    border-top: 4px solid #bf2e1a;
                ">
                    <h3 style="font-family: 'Noto Serif', serif; font-size: 1.5rem; color: #333; margin-bottom: 20px; font-weight: 600;">Submit a Ticket</h3>
                    <p style="font-size: 1rem; color: #555; margin-bottom: 20px;">If you have any questions or concerns, please fill out the form below. Our support team will get back to you as soon as possible.</p>
                    <form id="ticketForm" method="POST" action="">
                        <input type="text" name="name" placeholder="Your Name" required style="width: 100%; padding: 10px; margin-bottom: 10px;">
                        <input type="email" name="email" placeholder="Your Email" required style="width: 100%; padding: 10px; margin-bottom: 10px;">
                        <textarea name="message" placeholder="Your Message" required style="width: 100%; padding: 10px; margin-bottom: 10px;"></textarea>
                        <button type="submit" style="background: #bf2e1a; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">Submit</button>
                    </form>
                    <div id="successMessage" style="display: none; color: green; margin-top: 10px;">Your ticket has been submitted successfully!</div>
                </div>

                <div style="
                    background: white;
                    padding: 40px 30px;
                    border-radius: 15px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                    border-top: 4px solid #bf2e1a;
                ">
                    <h3 style="font-family: 'Noto Serif', serif; font-size: 1.5rem; color: #333; margin-bottom: 20px; font-weight: 600;">Customer Care</h3>
                    <p style="font-size: 1rem; color: #555; line-height: 1.6;">We are dedicated to helping you discover the perfect scent. Whether you need help with selecting a fragrance, tracking an order, or understanding our return policy, we are here to provide timely and personalized support.</p>
                </div>

                <div style="
                    background: white;
                    padding: 40px 30px;
                    border-radius: 15px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                    border-top: 4px solid #bf2e1a;
                ">
                    <h3 style="font-family: 'Noto Serif', serif; font-size: 1.5rem; color: #333; margin-bottom: 20px; font-weight: 600;">Contact Info</h3>
                    <p><strong>Phone:</strong> 07 4779 1243</p>
                    <p><strong>Fax:</strong> 4779 1244</p>
                    <p><strong>Address:</strong> 223 Queen St, Brisbane, Queensland</p>
                    <p><strong>Email:</strong> <a href="mailto:support@perfumis.com.au">support@perfumis.com.au</a></p>
                    <p>Reach out to us for any questions about our fragrances, custom perfume blends, gift sets, or delivery options. We are here to assist you with all things Perfumis.</p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketForm = document.getElementById('ticketForm');
            const successMessage = document.getElementById('successMessage');

            ticketForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(ticketForm);
                fetch('fetch_products.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText.includes('Ticket submitted successfully!')) {
                        successMessage.style.display = 'block';
                        ticketForm.reset();
                    } else {
                        alert('There was an issue submitting your ticket. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });
        });
    </script>
</body>
</html>
