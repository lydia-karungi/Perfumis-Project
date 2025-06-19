<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scent Quiz - Find Your Perfect Fragrance | Perfumis</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #bf2e1a;
            --secondary-color: #d73527;
            --accent-color: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --success-color: #10b981;
            --border-color: #e2e8f0;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-large: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quiz-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 50px;
            width: 100%;
            max-width: 700px;
            box-shadow: var(--shadow-large);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .quiz-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), #f59e0b, #10b981);
            border-radius: 32px 32px 0 0;
        }

        /* Welcome Screen */
        .welcome-screen {
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .welcome-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: var(--shadow-medium);
            animation: pulse 2s infinite;
        }

        .welcome-title {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 20px 0;
            background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin: 0 0 40px 0;
            line-height: 1.6;
        }

        .start-quiz-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-medium);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .start-quiz-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-large);
        }

        /* Quiz Screen */
        .quiz-screen {
            display: none;
            animation: fadeInUp 0.6s ease-out;
        }

        .quiz-header {
            margin-bottom: 40px;
        }

        .progress-container {
            background: #f1f5f9;
            border-radius: 20px;
            height: 12px;
            margin-bottom: 30px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .progress-text {
            text-align: center;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .question-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 40px 0;
            text-align: center;
            line-height: 1.3;
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .option-card {
            background: white;
            border: 3px solid transparent;
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-light);
            position: relative;
            overflow: hidden;
        }

        .option-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(191, 46, 26, 0.02), rgba(215, 53, 39, 0.02));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .option-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-large);
            border-color: var(--primary-color);
        }

        .option-card:hover::before {
            opacity: 1;
        }

        .option-card.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(191, 46, 26, 0.05), rgba(215, 53, 39, 0.05));
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
        }

        .option-image {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--accent-color);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-card:hover .option-image {
            transform: scale(1.1);
        }

        .option-card.selected .option-image {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .option-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            transition: color 0.3s ease;
        }

        .option-card.selected .option-text {
            color: var(--primary-color);
        }

        .quiz-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
        }

        .nav-btn {
            padding: 14px 28px;
            border-radius: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn {
            background: transparent;
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .back-btn:hover {
            background: var(--accent-color);
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        .next-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
            box-shadow: var(--shadow-light);
        }

        .next-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .next-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Results Screen */
        .results-screen {
            display: none;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .results-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, var(--success-color), #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: var(--shadow-medium);
        }

        .results-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 20px 0;
        }

        .scent-profile {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #92400e;
            margin: 0 0 15px 0;
        }

        .profile-description {
            color: #78350f;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .recommended-products {
            margin: 40px 0;
            text-align: left;
        }

        .recommendations-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 20px 0;
            text-align: center;
        }

        .product-recommendations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .recommendation-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .recommendation-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .recommendation-image {
            width: 100%;
            height: 120px;
            background: var(--accent-color);
            border-radius: 12px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-secondary);
        }

        .recommendation-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 8px 0;
        }

        .recommendation-price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .actions-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .action-btn {
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .primary-action {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
            box-shadow: var(--shadow-light);
        }

        .primary-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .secondary-action {
            background: transparent;
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .secondary-action:hover {
            background: var(--accent-color);
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .quiz-container {
                padding: 20px 15px;
            }

            .quiz-card {
                padding: 30px 25px;
                border-radius: 24px;
            }

            .welcome-title {
                font-size: 2.5rem;
            }

            .question-title {
                font-size: 1.5rem;
            }

            .options-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .option-card {
                padding: 25px 15px;
            }

            .quiz-navigation {
                flex-direction: column;
                gap: 15px;
            }

            .nav-btn,
            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .actions-container {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="quiz-container">
            <div class="quiz-card">
                <!-- Welcome Screen -->
                <div class="welcome-screen" id="welcomeScreen">
                    <div class="welcome-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <h1 class="welcome-title">Find Your Perfect Scent</h1>
                    <p class="welcome-subtitle">
                        Take our personalized quiz to discover fragrances that match your unique style and preferences. 
                        In just a few questions, we'll recommend the perfect scents for you.
                    </p>
                    <button class="start-quiz-btn" id="startQuizBtn">
                        <i class="fas fa-play"></i>
                        Start Quiz
                    </button>
                </div>

                <!-- Quiz Screen -->
                <div class="quiz-screen" id="quizScreen">
                    <div class="quiz-header">
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                        </div>
                        <div class="progress-text" id="progressText">Question 1 of 5</div>
                    </div>

                    <h2 class="question-title" id="questionTitle">Loading question...</h2>

                    <div class="options-container" id="optionsContainer">
                        <!-- Options will be dynamically inserted here -->
                    </div>

                    <div class="quiz-navigation">
                        <button class="nav-btn back-btn" id="backBtn" style="display: none;">
                            <i class="fas fa-chevron-left"></i>
                            Back
                        </button>
                        <button class="nav-btn next-btn" id="nextBtn" disabled>
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Results Screen -->
                <div class="results-screen" id="resultsScreen">
                    <div class="results-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h1 class="results-title">Your Perfect Scent Profile</h1>
                    
                    <div class="scent-profile" id="scentProfile">
                        <div class="profile-name" id="profileName">Loading...</div>
                        <div class="profile-description" id="profileDescription">
                            Analyzing your preferences to find the perfect match...
                        </div>
                    </div>

                    <div class="recommended-products" id="recommendedProducts">
                        <h3 class="recommendations-title">Recommended For You</h3>
                        <div class="product-recommendations" id="productRecommendations">
                            <!-- Recommendations will be inserted here -->
                        </div>
                    </div>

                    <div class="actions-container">
                        <a href="#" class="action-btn primary-action" id="shopRecommendationsBtn">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Recommendations
                        </a>
                        <button class="action-btn secondary-action" id="retakeQuizBtn">
                            <i class="fas fa-redo"></i>
                            Retake Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        class ScentQuiz {
            constructor() {
                this.questions = [];
                this.currentQuestionIndex = 0;
                this.answers = [];
                this.isLoading = false;
                
                this.initializeElements();
                this.bindEvents();
                this.loadQuestions();
            }

            initializeElements() {
                this.welcomeScreen = document.getElementById('welcomeScreen');
                this.quizScreen = document.getElementById('quizScreen');
                this.resultsScreen = document.getElementById('resultsScreen');
                this.startQuizBtn = document.getElementById('startQuizBtn');
                this.progressBar = document.getElementById('progressBar');
                this.progressText = document.getElementById('progressText');
                this.questionTitle = document.getElementById('questionTitle');
                this.optionsContainer = document.getElementById('optionsContainer');
                this.backBtn = document.getElementById('backBtn');
                this.nextBtn = document.getElementById('nextBtn');
                this.retakeQuizBtn = document.getElementById('retakeQuizBtn');
            }

            bindEvents() {
                this.startQuizBtn.addEventListener('click', () => this.startQuiz());
                this.backBtn.addEventListener('click', () => this.previousQuestion());
                this.nextBtn.addEventListener('click', () => this.nextQuestion());
                this.retakeQuizBtn.addEventListener('click', () => this.resetQuiz());
                
                // Shop recommendations button
                document.addEventListener('click', (e) => {
                    if (e.target.id === 'shopRecommendationsBtn' || e.target.closest('#shopRecommendationsBtn')) {
                        e.preventDefault();
                        const profileName = document.getElementById('profileName').textContent;
                        let categoryFilter = '';
                        
                        // Map profile to category filter
                        if (profileName.includes('Fresh')) {
                            categoryFilter = '?category=unisex';
                        } else if (profileName.includes('Romantic')) {
                            categoryFilter = '?category=women';
                        } else if (profileName.includes('Bold')) {
                            categoryFilter = '?category=men';
                        } else if (profileName.includes('Warm')) {
                            categoryFilter = '?category=luxury';
                        }
                        
                        window.location.href = `collections.php${categoryFilter}`;
                    }
                });
            }

            async loadQuestions() {
                try {
                    // For demo purposes, using mock data
                    // In production, this would fetch from your PHP endpoint
                    this.questions = [
                        {
                            id: 1,
                            text: "Which fragrance family do you prefer?",
                            options: [
                                { id: 1, text: "Floral", icon: "🌸", tags: ["romantic", "feminine", "garden"] },
                                { id: 2, text: "Woody", icon: "🌳", tags: ["warm", "masculine", "earthy"] },
                                { id: 3, text: "Citrus", icon: "🍊", tags: ["fresh", "energetic", "zesty"] },
                                { id: 4, text: "Fresh", icon: "🌿", tags: ["clean", "aquatic", "crisp"] }
                            ]
                        },
                        {
                            id: 2,
                            text: "When do you usually wear perfume?",
                            options: [
                                { id: 1, text: "Daily", icon: "☀️", tags: ["everyday", "office", "casual"] },
                                { id: 2, text: "Special Occasions", icon: "✨", tags: ["evening", "formal", "luxury"] },
                                { id: 3, text: "Work", icon: "💼", tags: ["professional", "subtle", "sophisticated"] },
                                { id: 4, text: "Casual Outings", icon: "🎉", tags: ["relaxed", "friendly", "versatile"] }
                            ]
                        },
                        {
                            id: 3,
                            text: "What kind of scent do you prefer?",
                            options: [
                                { id: 1, text: "Sweet & Romantic", icon: "💕", tags: ["vanilla", "fruity", "gourmand"] },
                                { id: 2, text: "Bold & Musky", icon: "🔥", tags: ["strong", "sensual", "intense"] },
                                { id: 3, text: "Light & Airy", icon: "☁️", tags: ["subtle", "delicate", "soft"] },
                                { id: 4, text: "Spicy & Warm", icon: "🌶️", tags: ["cinnamon", "exotic", "rich"] }
                            ]
                        },
                        {
                            id: 4,
                            text: "Which season speaks to you most?",
                            options: [
                                { id: 1, text: "Spring", icon: "🌱", tags: ["fresh", "blooming", "renewal"] },
                                { id: 2, text: "Summer", icon: "🏖️", tags: ["citrus", "cooling", "bright"] },
                                { id: 3, text: "Autumn", icon: "🍂", tags: ["warm", "spicy", "cozy"] },
                                { id: 4, text: "Winter", icon: "❄️", tags: ["intense", "deep", "luxurious"] }
                            ]
                        },
                        {
                            id: 5,
                            text: "What's your preferred fragrance intensity?",
                            options: [
                                { id: 1, text: "Subtle", icon: "🌫️", tags: ["light", "delicate", "gentle"] },
                                { id: 2, text: "Moderate", icon: "🌤️", tags: ["balanced", "noticeable", "versatile"] },
                                { id: 3, text: "Strong", icon: "🌟", tags: ["bold", "statement", "powerful"] },
                                { id: 4, text: "Very Intense", icon: "💥", tags: ["dramatic", "luxurious", "unforgettable"] }
                            ]
                        }
                    ];
                } catch (error) {
                    console.error('Error loading questions:', error);
                }
            }

            startQuiz() {
                this.welcomeScreen.style.display = 'none';
                this.quizScreen.style.display = 'block';
                this.showQuestion(0);
            }

            showQuestion(index) {
                if (index >= this.questions.length) {
                    this.showResults();
                    return;
                }

                const question = this.questions[index];
                const progress = ((index + 1) / this.questions.length) * 100;

                this.questionTitle.textContent = question.text;
                this.progressBar.style.width = `${progress}%`;
                this.progressText.textContent = `Question ${index + 1} of ${this.questions.length}`;

                this.renderOptions(question.options);
                this.updateNavigation();
            }

            renderOptions(options) {
                this.optionsContainer.innerHTML = '';
                
                options.forEach(option => {
                    const optionCard = document.createElement('div');
                    optionCard.className = 'option-card';
                    optionCard.dataset.optionId = option.id;
                    
                    optionCard.innerHTML = `
                        <div class="option-image">
                            <span style="font-size: 2.5rem;">${option.icon}</span>
                        </div>
                        <div class="option-text">${option.text}</div>
                    `;

                    optionCard.addEventListener('click', () => this.selectOption(option));
                    this.optionsContainer.appendChild(optionCard);
                });

                // Restore previous selection if going back
                if (this.answers[this.currentQuestionIndex]) {
                    const selectedId = this.answers[this.currentQuestionIndex].id;
                    const selectedCard = this.optionsContainer.querySelector(`[data-option-id="${selectedId}"]`);
                    if (selectedCard) {
                        selectedCard.classList.add('selected');
                    }
                }
            }

            selectOption(option) {
                // Clear previous selections
                this.optionsContainer.querySelectorAll('.option-card').forEach(card => {
                    card.classList.remove('selected');
                });

                // Select current option
                const selectedCard = this.optionsContainer.querySelector(`[data-option-id="${option.id}"]`);
                selectedCard.classList.add('selected');

                // Store answer
                this.answers[this.currentQuestionIndex] = option;
                
                // Enable next button
                this.nextBtn.disabled = false;

                // Add selection animation
                selectedCard.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    selectedCard.style.transform = '';
                }, 150);
            }

            updateNavigation() {
                this.backBtn.style.display = this.currentQuestionIndex > 0 ? 'block' : 'none';
                this.nextBtn.disabled = !this.answers[this.currentQuestionIndex];
                
                if (this.currentQuestionIndex === this.questions.length - 1) {
                    this.nextBtn.innerHTML = `
                        <span class="loading-spinner" style="display: none;"></span>
                        <span class="btn-text">Get Results</span>
                        <i class="fas fa-heart"></i>
                    `;
                } else {
                    this.nextBtn.innerHTML = `
                        Next
                        <i class="fas fa-chevron-right"></i>
                    `;
                }
            }

            nextQuestion() {
                if (this.currentQuestionIndex < this.questions.length - 1) {
                    this.currentQuestionIndex++;
                    this.showQuestion(this.currentQuestionIndex);
                } else {
                    this.completeQuiz();
                }
            }

            previousQuestion() {
                if (this.currentQuestionIndex > 0) {
                    this.currentQuestionIndex--;
                    this.showQuestion(this.currentQuestionIndex);
                }
            }

            async completeQuiz() {
                // Show loading state
                this.nextBtn.disabled = true;
                const spinner = this.nextBtn.querySelector('.loading-spinner');
                const btnText = this.nextBtn.querySelector('.btn-text');
                if (spinner && btnText) {
                    spinner.style.display = 'inline-block';
                    btnText.textContent = 'Analyzing...';
                }

                try {
                    // Simulate API call delay
                    await new Promise(resolve => setTimeout(resolve, 2000));
                    
                    // Calculate results based on answers
                    const results = this.calculateResults();
                    
                    // Save to database (in production)
                    await this.saveResults(results);
                    
                    this.showResults(results);
                } catch (error) {
                    console.error('Error completing quiz:', error);
                    alert('Sorry, there was an error processing your results. Please try again.');
                }
            }

            calculateResults() {
                // Analyze answers to determine scent profile
                const allTags = this.answers.flatMap(answer => answer.tags);
                const tagCounts = {};
                
                allTags.forEach(tag => {
                    tagCounts[tag] = (tagCounts[tag] || 0) + 1;
                });

                // Define scent profiles
                const profiles = {
                    'Fresh & Clean': {
                        keywords: ['fresh', 'clean', 'light', 'citrus', 'aquatic'],
                        description: 'You love crisp, refreshing scents that make you feel energized and confident. Perfect for everyday wear.',
                        recommendations: [
                            { name: 'Ocean Breeze', price: 85.00, category: 'Fresh' },
                            { name: 'Citrus Bloom', price: 78.99, category: 'Citrus' },
                            { name: 'Morning Dew', price: 92.00, category: 'Fresh' }
                        ]
                    },
                    'Romantic & Feminine': {
                        keywords: ['romantic', 'feminine', 'floral', 'sweet', 'soft'],
                        description: 'You gravitate toward soft, romantic fragrances with floral and sweet notes that express your elegant side.',
                        recommendations: [
                            { name: 'Rose Garden', price: 125.00, category: 'Floral' },
                            { name: 'Sweet Dreams', price: 94.50, category: 'Gourmand' },
                            { name: 'Velvet Rose', price: 110.00, category: 'Floral' }
                        ]
                    },
                    'Bold & Confident': {
                        keywords: ['bold', 'strong', 'intense', 'musky', 'dramatic'],
                        description: 'You prefer powerful, statement-making fragrances that command attention and reflect your confident personality.',
                        recommendations: [
                            { name: 'Midnight Oud', price: 150.00, category: 'Oriental' },
                            { name: 'Bold Statement', price: 135.00, category: 'Woody' },
                            { name: 'Dark Mystery', price: 145.00, category: 'Musky' }
                        ]
                    },
                    'Warm & Sophisticated': {
                        keywords: ['warm', 'sophisticated', 'woody', 'spicy', 'rich'],
                        description: 'You appreciate complex, sophisticated fragrances with warm, woody, and spicy notes that mature beautifully.',
                        recommendations: [
                            { name: 'Sandalwood Dreams', price: 115.00, category: 'Woody' },
                            { name: 'Spice Market', price: 105.00, category: 'Spicy' },
                            { name: 'Amber Nights', price: 120.00, category: 'Oriental' }
                        ]
                    }
                };

                // Find best matching profile
                let bestMatch = 'Fresh & Clean';
                let maxScore = 0;

                Object.entries(profiles).forEach(([profileName, profile]) => {
                    const score = profile.keywords.reduce((sum, keyword) => {
                        return sum + (tagCounts[keyword] || 0);
                    }, 0);

                    if (score > maxScore) {
                        maxScore = score;
                        bestMatch = profileName;
                    }
                });

                return {
                    profile: bestMatch,
                    ...profiles[bestMatch],
                    answers: this.answers
                };
            }

            async saveResults(results) {
                try {
                    // In production, send results to server
                    const response = await fetch('save_quiz_results.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(results)
                    });
                    
                    if (!response.ok) {
                        throw new Error('Failed to save results');
                    }
                } catch (error) {
                    console.error('Error saving results:', error);
                    // Continue anyway - results are still shown to user
                }
            }

            showResults(results = null) {
                this.quizScreen.style.display = 'none';
                this.resultsScreen.style.display = 'block';

                if (results) {
                    document.getElementById('profileName').textContent = results.profile;
                    document.getElementById('profileDescription').textContent = results.description;

                    // Display recommendations
                    const recommendationsContainer = document.getElementById('productRecommendations');
                    recommendationsContainer.innerHTML = results.recommendations.map(product => `
                        <div class="recommendation-card">
                            <div class="recommendation-image">
                                <i class="fas fa-spa"></i>
                            </div>
                            <div class="recommendation-name">${product.name}</div>
                            <div class="recommendation-price">${product.price.toFixed(2)}</div>
                        </div>
                    `).join('');
                }

                // Trigger completion notification
                this.showCompletionMessage();
            }

            showCompletionMessage() {
                // Create a success notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #10b981, #059669);
                    color: white;
                    padding: 20px 25px;
                    border-radius: 16px;
                    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
                    z-index: 1000;
                    animation: slideInRight 0.5s ease-out;
                    max-width: 350px;
                `;
                
                notification.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                        <div>
                            <div style="font-weight: 600; margin-bottom: 4px;">Quiz Completed!</div>
                            <div style="font-size: 0.9rem; opacity: 0.9;">Your scent preferences have been recorded.</div>
                        </div>
                    </div>
                `;

                document.body.appendChild(notification);

                // Remove after 4 seconds
                setTimeout(() => {
                    notification.remove();
                }, 4000);
            }

            resetQuiz() {
                this.currentQuestionIndex = 0;
                this.answers = [];
                this.resultsScreen.style.display = 'none';
                this.welcomeScreen.style.display = 'block';
            }
        }

        // Initialize quiz when page loads
        document.addEventListener('DOMContentLoaded', () => {
            new ScentQuiz();
        });
    </script>
</body>
</html>