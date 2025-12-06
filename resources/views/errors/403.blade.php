<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>Assessment Violation</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .violation-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .violation-content {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(220, 53, 69, 0.1);
            overflow: hidden;
            max-width: 1200px;
            width: 100%;
            border: 1px solid rgba(220, 53, 69, 0.1);
        }

        .violation-header {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .violation-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .violation-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .violation-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .violation-body {
            padding: 50px;
        }

        .violation-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #212529;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .violation-text {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .email-link {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: #dc3545;
            font-weight: 600;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .email-link:hover {
            background: #fff5f5;
            border-color: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.1);
        }

        .email-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-home {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .btn-contact {
            background: white;
            border: 2px solid #dc3545;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            color: #dc3545;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-contact:hover {
            background: #fff5f5;
            transform: translateY(-3px);
            color: #dc3545;
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.1);
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .warning-note {
            background: #fff8e6;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .warning-note h6 {
            color: #e0a800;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .warning-note p {
            color: #856404;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        @media (max-width: 992px) {
            .violation-body {
                padding: 40px 30px;
            }

            .violation-title {
                font-size: 2rem;
            }

            .violation-header {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .violation-title {
                font-size: 1.75rem;
            }

            .violation-text {
                font-size: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-home,
            .btn-contact {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .violation-wrapper {
                padding: 10px;
            }

            .violation-body {
                padding: 30px 20px;
            }

            .violation-header {
                padding: 25px;
            }

            .violation-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>
    <div class="violation-wrapper">
        <div class="violation-content">
            <div class="violation-header">
                <div class="violation-icon">
                    <i class="bi bi-shield-slash-fill"></i>
                </div>
                <h2 class="mb-0">Assessment Terminated</h2>
                <p class="mb-0 opacity-75">Rule violation detected</p>
            </div>

            <div class="violation-body">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="violation-title">
                            Assessment Ended Instantly!
                        </h1>

                        <p class="violation-text">
                            Oops! Looks like you violated one of our assessment rules.
                            Our system has automatically terminated your assessment session
                            to maintain exam integrity.
                        </p>

                        <p class="violation-text">
                            If you believe this was an error or have questions about what
                            happened, please contact our support team for assistance.
                        </p>

                        <a href="mailto:smctgroup2021@gmail.com" class="email-link">
                            <i class="bi bi-envelope-at"></i>
                            smctgroup2021@gmail.com
                        </a>

                        <div class="action-buttons">
                            <a href="/" class="btn-home">
                                <i class="bi bi-house-door me-2"></i>
                                Visit Our Site
                            </a>
                            <a href="mailto:smctgroup2021@gmail.com" class="btn-contact">
                                <i class="bi bi-envelope-paper me-2"></i>
                                Send Email
                            </a>
                        </div>

                        <div class="warning-note">
                            <h6>
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Important Notice
                            </h6>
                            <p>
                                Future violations may result in permanent restrictions.
                                Please review the assessment guidelines before attempting again.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{ asset('images/vectors/violation.png') }}" class="illustration-img"
                                alt="Violation Illustration"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjIwMCIgcj0iMTgwIiBmaWxsPSIjZmY1ZjVmIi8+CjxwYXRoIGQ9Ik0xNTAgMTUwTDI1MCAyNTBNMjUwIDE1MEwxNTAgMjUwIiBzdHJva2U9IiNkYzM1NDUiIHN0cm9rZS13aWR0aD0iOCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjIwMCIgcj0iODAiIHN0cm9rZT0iI2IwMmEzNyIgc3Ryb2tlLXdpZHRoPSI0IiBzdHJva2UtZGFzaGFycmF5PSIxMCA1Ii8+Cjwvc3ZnPg=='">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
