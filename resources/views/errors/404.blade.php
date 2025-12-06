<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>404 - Page Not Found</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');

        :root {
            --space-blue: #0a0e2a;
            --space-purple: #3a0ca3;
            --neon-blue: #4361ee;
            --neon-pink: #f72585;
            --star-glow: #ffd700;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0a0e2a 0%, #1a1b3a 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: white;
        }

        .space-container {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Background Stars */
        .stars-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/vectors/overlay_stars.svg') }}') repeat;
            background-size: 300px;
            opacity: 0.3;
            z-index: 1;
        }

        /* Animated Stars */
        .animated-stars {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            animation: twinkle 3s infinite ease-in-out;
        }

        .star:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 2px;
            height: 2px;
            animation-delay: 0s;
        }

        .star:nth-child(2) {
            top: 40%;
            left: 80%;
            width: 3px;
            height: 3px;
            animation-delay: 1s;
        }

        .star:nth-child(3) {
            top: 60%;
            left: 30%;
            width: 2px;
            height: 2px;
            animation-delay: 2s;
        }

        .star:nth-child(4) {
            top: 80%;
            left: 60%;
            width: 3px;
            height: 3px;
            animation-delay: 3s;
        }

        .star:nth-child(5) {
            top: 30%;
            left: 50%;
            width: 2px;
            height: 2px;
            animation-delay: 4s;
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
                box-shadow: 0 0 10px var(--star-glow);
            }
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .error-card {
            background: rgba(26, 27, 58, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            max-width: 1200px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-pink));
        }

        .error-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .error-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-pink));
            color: white;
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .error-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 6rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(67, 97, 238, 0.3);
            line-height: 1;
        }

        .error-subtitle {
            font-size: 2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
        }

        .error-description {
            color: #a0aec0;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        /* Space Objects */
        .space-objects {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 5;
        }

        /* Earth */
        .object_earth {
            position: absolute;
            top: 10%;
            left: 5%;
            width: 120px;
            height: 120px;
            animation: spin-earth 100s infinite linear;
            filter: drop-shadow(0 0 20px rgba(67, 97, 238, 0.5));
        }

        @keyframes spin-earth {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Moon */
        .object_moon {
            position: absolute;
            top: 5%;
            left: 20%;
            width: 60px;
            height: 60px;
            animation: orbit-moon 50s infinite linear;
        }

        @keyframes orbit-moon {
            0% {
                transform: rotate(0deg) translateX(100px) rotate(0deg);
            }

            100% {
                transform: rotate(360deg) translateX(100px) rotate(-360deg);
            }
        }

        /* Rocket */
        .object_rocket {
            position: absolute;
            width: 60px;
            height: 60px;
            bottom: 20%;
            right: 10%;
            animation: rocket-flight 20s infinite linear;
            filter: drop-shadow(0 0 15px rgba(247, 37, 133, 0.5));
        }

        @keyframes rocket-flight {
            0% {
                transform: translate(0, 0) rotate(45deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translate(-1000px, -500px) rotate(45deg);
                opacity: 0;
            }
        }

        /* Astronaut */
        .box_astronaut {
            position: absolute;
            bottom: 15%;
            right: 20%;
            animation: float-astronaut 6s infinite ease-in-out;
        }

        .object_astronaut {
            width: 140px;
            height: 140px;
            animation: rotate-astronaut 20s infinite linear;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));
        }

        @keyframes float-astronaut {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-30px);
            }
        }

        @keyframes rotate-astronaut {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-space {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-space::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
            z-index: -1;
        }

        .btn-space:hover::before {
            left: 100%;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-pink));
            color: white;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .btn-explore {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-explore:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }

        /* Search Box */
        .search-container {
            max-width: 500px;
            margin: 2rem auto;
            position: relative;
        }

        .search-box {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 1rem 2rem 1rem 3rem;
            color: white;
            font-size: 1rem;
            width: 100%;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--neon-blue);
            box-shadow: 0 0 20px rgba(67, 97, 238, 0.3);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .error-title {
                font-size: 5rem;
            }

            .error-subtitle {
                font-size: 1.75rem;
            }

            .object_earth {
                width: 100px;
                height: 100px;
            }

            .box_astronaut {
                right: 10%;
            }
        }

        @media (max-width: 768px) {
            .error-title {
                font-size: 4rem;
            }

            .error-subtitle {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 1rem;
            }

            .error-card {
                padding: 2rem;
            }

            .object_earth,
            .object_moon,
            .box_astronaut,
            .object_rocket {
                opacity: 0.7;
            }
        }

        @media (max-width: 576px) {
            .error-title {
                font-size: 3rem;
            }

            .error-subtitle {
                font-size: 1.25rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-space {
                width: 100%;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* Error Illustration */
        .error-illustration {
            max-width: 400px;
            margin: 0 auto 2rem;
        }

        .error-illustration img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 0 30px rgba(67, 97, 238, 0.3));
        }
    </style>
</head>

<body>
    <div class="space-container">
        <!-- Background -->
        <div class="stars-bg"></div>

        <!-- Animated Stars -->
        <div class="animated-stars">
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
        </div>

        <!-- Space Objects -->
        <div class="space-objects">
            <img class="object_earth" src="{{ asset('images/vectors/earth.svg') }}" alt="Earth">
            <img class="object_moon" src="{{ asset('images/vectors/moon.svg') }}" alt="Moon">
            <img class="object_rocket" src="{{ asset('images/vectors/rocket.svg') }}" alt="Rocket">
            <div class="box_astronaut">
                <img class="object_astronaut" src="{{ asset('images/vectors/astronaut.png') }}" alt="Astronaut">
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="error-card">
                <div class="error-header">
                    <div class="error-badge">
                        <i class="bi bi-rocket-takeoff me-2"></i>
                        LOST IN SPACE
                    </div>

                    <div class="error-illustration">
                        <img src="{{ asset('images/vectors/404.svg') }}" alt="404 Error">
                    </div>

                    <h1 class="error-title">404</h1>
                    <h2 class="error-subtitle">Page Not Found</h2>

                    <p class="error-description">
                        Oops! The page you're looking for seems to have drifted off into the cosmic void.
                        It might have been moved, deleted, or maybe it never existed in this dimension.
                    </p>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="/" class="btn-space btn-home">
                            <i class="bi bi-house-door me-2"></i>
                            Back to Home Planet
                        </a>
                    </div>

                    <!-- Tech Info -->
                    <div class="mt-5 pt-4 border-top border-secondary border-opacity-25">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Error Code: 404 - Resource Not Found
                                </small>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ date('Y-m-d H:i:s') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to buttons
            const buttons = document.querySelectorAll('.btn-space');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.3);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                    `;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            // Search functionality
            const searchBox = document.querySelector('.search-box');
            if (searchBox) {
                searchBox.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = `/search?q=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }

            // Add parallax effect to stars
            document.addEventListener('mousemove', function(e) {
                const stars = document.querySelector('.stars-bg');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                stars.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
            });
        });
    </script>
</body>

</html>
