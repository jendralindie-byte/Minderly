<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuesioner Profil - Minderly')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #edf7ff;
            color: #243447;
        }

        .quiz-header {
            background: #075087;
            color: white;
            padding: 22px 6%;
        }

        .quiz-brand {
            font-size: 24px;
            font-weight: 800;
        }

        .quiz-subtitle {
            margin-top: 5px;
            color: #dceeff;
            font-size: 13px;
        }

        .quiz-main {
            width: min(100% - 32px, 900px);
            margin: 40px auto;
        }

        .quiz-progress {
            height: 7px;
            background: #d8e8f5;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 20px;
        }

        .quiz-progress span {
            display: block;
            width: 100%;
            height: 100%;
            background: #075087;
        }

        .quiz-card {
            background: white;
            border: 1px solid #e1e8ef;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(20, 50, 80, .05);
        }

        @media (max-width: 640px) {
            .quiz-main {
                margin-top: 24px;
            }

            .quiz-card {
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <header class="quiz-header">
        <div class="quiz-brand">✓ MINDERLY</div>
        <div class="quiz-subtitle">Task Management System</div>
    </header>

    <main class="quiz-main">
        @yield('content')
    </main>
</body>
</html>
