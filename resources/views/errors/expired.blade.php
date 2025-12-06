<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>Link Invalid</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .gradient-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #8e36e0 0%, #164b92 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .content-wrapper {
            max-width: 1200px;
            width: 100%;
            margin: auto;
        }

        .message-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .error-badge {
            display: inline-block;
            background: linear-gradient(135deg, #8e36e0, #164b92);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(142, 54, 224, 0.3);
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .lead-text {
            font-size: 1.25rem;
            color: #4a5568;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #8e36e0, #164b92);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(142, 54, 224, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(142, 54, 224, 0.4);
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.2));
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @media (max-width: 992px) {
            .message-card {
                padding: 40px 30px;
            }

            h1 {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            .lead-text {
                font-size: 1.1rem;
            }

            .btn-primary-custom {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .gradient-bg {
                padding: 15px;
            }

            .message-card {
                padding: 30px 20px;
                border-radius: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="gradient-bg">
        <div class="content-wrapper">
            <div class="message-card">
                <div class="row align-items-center">
                    <!-- Text Content -->
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="error-badge">
                            <i class="bi bi-clock me-2"></i>
                            Link Expired
                        </div>

                        <h1>
                            This invitation is no longer valid
                        </h1>

                        <p class="lead-text">
                            The link you're trying to access has expired or has already been used.
                            For security reasons, invitation links are only valid for a limited time.
                        </p>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="/home" class="btn btn-primary-custom text-white">
                                <i class="bi bi-house-door me-2"></i>
                                Go to Homepage
                            </a>
                        </div>

                        <!-- Help Tips -->
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-lightbulb me-2"></i>
                                Need help?
                            </h6>
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Check if you have a newer invitation
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    Ensure you're logged in with the correct account
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Illustration -->
                    <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                        <div class="text-center">
                            <img src="{{asset('images/vectors/time.png')}}"
                                 class="illustration-img"
                                 alt="Expired Link Illustration"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAwIiBjeT0iMjAwIiByPSIxODAiIGZpbGw9InVybCgjZ3JhZGllbnQpIiBvcGFjaXR5PSIwLjEiLz48cGF0aCBkPSJNMTUwIDE1MEwyNTAgMjUwTTI1MCAxNTBMMTUwIDI1MCIgc3Ryb2tlPSIjOGUzNmUwIiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjxjaXJjbGUgY3g9IjIwMCIgY3k9IjIwMCIgcj0iODAiIHN0cm9rZT0iIzE2NGI5MiIgc3Ryb2tlLXdpZHRoPSI0IiBzdHJva2UtZGFzaGFycmF5PSIxMCA1Ii8+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkaWVudCIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzhlMzZlMCIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzE2NGI5MiIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjwvc3ZnPg=='">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
