<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Minderly</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #263548;
        }

        .auth-container {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            width: 100%;
            max-width: 1000px;
            min-height: 580px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(35,52,72,.10);
        }

        .auth-brand {
            background: #97a9b8;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
        }

        .auth-brand h1 {
            font-size: 42px;
            font-weight: 750;
            letter-spacing: -1.5px;
            margin-bottom: 14px;
        }

        .auth-brand p {
            font-size: 14px;
            line-height: 1.8;
            color: #f2f5f8;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 45px 75px;
        }

        .auth-form h2 {
            text-align: center;
            font-size: 29px;
            margin-bottom: 28px;
            color: #263548;
        }

        .form-group { margin-bottom: 17px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #526174;
        }

        .form-group input {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #d9e0e7;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #849caf;
            box-shadow: 0 0 0 3px rgba(132,156,175,.15);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #91a5b5;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: 650;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn-submit:hover { background: #7d93a5; }

        a {
            color: #718da5;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover { text-decoration: underline; }

        .auth-footer {
            margin-top: 22px;
            text-align: center;
            color: #718096;
            font-size: 13px;
        }

        .error-message {
            background: #fff0f0;
            color: #b42318;
            border: 1px solid #ffd4d4;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        @media (max-width: 700px) {
            body { padding: 14px; }
            .auth-container { grid-template-columns: 1fr; }
            .auth-brand { padding: 30px 20px; }
            .auth-brand h1 { font-size: 34px; }
            .auth-form { padding: 35px 25px; }
        }
    </style>
</head>
<body>

<div class="auth-container">
    <section class="auth-brand">
        <h1>Minderly</h1>
        <p>Mulai atur tugas dengan lebih terarah<br>dan temukan cara kerja terbaikmu.</p>
    </section>

    <section class="auth-form">
        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Nama lengkap"
                    value="{{ old('nama') }}"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="btn-submit">
                Create Account &rarr;
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Sign In</a>
        </div>
    </section>
</div>

</body>
</html>
