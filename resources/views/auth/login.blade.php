<!doctype html>
<html lang="en">

<head>
    <title>Login | Network Monitoring MTT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;800&display=swap" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background: url("{{ asset('assets/images/application/bg.png') }}") no-repeat center center fixed;
            background-size: cover;
        }

        /* overlay gelap */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        /* center */
        .wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ================= LOGIN STYLE ================= */

        .login-container {
            position: relative;
            perspective: 1000px;
            width: 240px;
        }

        .login-card {
            position: relative;
            width: 100%;
            height: 80px;
            background: linear-gradient(135deg, #ff3366, #ff6b35);
            border: 4px solid #000;
            box-shadow:
                8px 8px 0 #000,
                16px 16px 0 rgba(255, 51, 102, 0.3);
            cursor: pointer;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-style: preserve-3d;
        }

        .login-card:hover {
            height: 260px;
            transform: translateZ(20px) rotateX(5deg) rotateY(-5deg);
            box-shadow:
                12px 12px 0 #000,
                24px 24px 0 rgba(255, 51, 102, 0.4),
                0 0 50px rgba(255, 51, 102, 0.6);
        }

        .login-title {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: inherit;
            transition: all 0.4s ease;
        }

        .login-text {
            color: #000;
            font-weight: 800;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.4s ease;
        }

        .login-card:hover .login-text {
            opacity: 0;
            transform: translateY(-30px) scale(0.8);
        }

        .login-form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
            opacity: 0;
            transform: translateY(30px) scale(0.8);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .login-card:hover .login-form {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .login-input {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.8);
            border: 3px solid #000;
            font-weight: 700;
            color: #000;
            box-shadow: 4px 4px 0 #000;
            transition: all 0.3s;
        }

        .login-input:focus {
            outline: none;
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0 #000;
        }

        .login-input::placeholder {
            color: #000;
            opacity: 0.6;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background: #000;
            color: #fff;
            border: none;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 4px 4px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
        }

        .login-btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0 rgba(255, 255, 255, 0.3);
            background: #333;
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.4),
                    transparent);
            transition: left 0.7s;
        }

        .login-card:hover::before {
            left: 100%;
        }

        .login-card::after {
            content: "";
            position: absolute;
            top: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            background: #000;
            clip-path: polygon(0 0, 100% 0, 100% 100%);
        }

        .login-card:hover::after {
            background: rgb(246, 168, 116);
        }

        .login-container::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 51, 102, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.6s;
            z-index: -1;
        }

        .login-container:hover::before {
            width: 400px;
            height: 400px;
        }

        .error-box {
            color: #fff;
            font-size: 12px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="login-container">
            <div class="login-card">

                <!-- LOGO + TITLE -->
                <div class="login-title">
                    <div style="text-align:center;">
                        <img src="{{ asset('assets/images/application/logop.png') }}" style="max-width:100px;">
                        <div class="login-text">Login</div>
                    </div>
                </div>

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    @if($errors->any())
                        <div class="error-box">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="input-group">
                        <input type="email" name="email" class="login-input" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" class="login-input" placeholder="Password" required>
                    </div>

                    <button type="submit" class="login-btn">LOGIN</button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>