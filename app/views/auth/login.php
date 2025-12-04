<?php

$error = $error ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>

    <style>
        body {
            background: #e3e3e3ff;
            font-family: "Segoe UI", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container { display: flex; justify-content: center; align-items: center; width: 100%; }
        .card {
            box-sizing: border-box;
            width: 260px;
            padding: 1.9rem 1.2rem;
            text-align: center;
            background: #2a2b38;
            border-radius: 12px;
            border: 1px solid #ffffff22;
            backdrop-filter: blur(6px);
            box-shadow: 0px 8px 30px rgba(0,0,0,0.25);
            transition: 0.4s ease;
        }

        .card:hover {
            border: 1px solid #92bfba;
            transform: scale(1.03);
            box-shadow: 0px 12px 40px rgba(0,0,0,0.35);
        }

        .logo-box { 
            display: flex; 
            justify-content: center; 
            margin-bottom: .7rem; 
            margin-top: -10px; 
        }

        .logo-icon { 
            width: 55px; 
            height: 55px; 
        }

        .field { 
            margin-top: .5rem; 
            display: flex; 
            align-items: center; 
            gap: .5em; 
            background-color: #1f2029; 
            border-radius: 4px; 
            padding: .5em 1em; 
            position: relative; 
        }

        .input-icon { 
            height: 1em; 
            width: 1em; 
            fill: #92bfba; 
        }
        .input-field { 
            background: none; 
            border: none; 
            outline: none; 
            width: 100%; 
            color: #d3d3d3; 
        }
        .eye-icon { 
            width: 1.1em; 
            height: 1.1em; 
            fill: #92bfba; 
            cursor: pointer; 
            position: absolute; 
            right: 12px; 
        }
        .title { 
            margin-bottom: 1rem; 
            font-size: 1.5em; 
            font-weight: 500; 
            color: #f5f5f5; 
        }
        .btn { 
            margin: 1rem 0; 
            border: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: .8em; 
            text-transform: uppercase; 
            padding: 0.6em 1.2em; 
            background-color: #92bfba; 
            color: #5e6681; 
            width: 100%; 
            cursor: pointer; 
        }
        .btn:hover { 
            background-color: #5e6681; 
            color: #92bfba; 
        }

        .error-box { 
            background: #ffcdcd; 
            padding: 12px; 
            border-left: 4px solid red; 
            margin-bottom: 15px; 
            border-radius: 6px; 
            color: #700000; 
        }
        
    </style>
</head>

<body>

<div class="login-container">
    <div class="card">

        <div class="logo-box">
            <svg class="logo-icon" viewBox="0 0 24 24">
                <path fill="#92bfba" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                <path fill="#2a2b38" d="M12 21c-4.41-1.08-7-5.41-7-10V6.3l7-3.11 7 3.11V11c0 4.59-2.59 8.92-7 10z"/>
            </svg>
        </div>

        <h4 class="title">Log In!</h4>

        <?php if ($error): ?>
            <div class="error-box"><?= $error ?></div>
        <?php endif; ?>

        <!-- FIX: form action kosong = submit ke file ini -->
        <form method="POST" action="<?= BASE_URL ?>login/process">



            <div class="field">
                <svg class="input-icon" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 
                    2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 
                    1.7-10 5v2h20v-2c0-3.3-6.7-5-10-5z"></path>
                </svg>
                <input autocomplete="off" placeholder="Username" class="input-field" name="username" type="text">
            </div>

            <div class="field">
                <svg class="input-icon" viewBox="0 0 24 24">
                    <path d="M17 8h-1V6c0-2.8-2.2-5-5-5S6 
                    3.2 6 6v2H5c-1.7 0-3 1.3-3 
                    3v10c0 1.7 1.3 3 3 3h12c1.7 0 
                    3-1.3 3-3V11c0-1.7-1.3-3-3-3zm-5 
                    9c-1.1 0-2-.9-2-2s.9-2 2-2 
                    2 .9 2 2-.9 2-2 
                    2zm3-9H8V6c0-1.7 1.3-3 3-3s3 
                    1.3 3 3v2z"></path>
                </svg>

                <input id="passwordField" autocomplete="off" placeholder="Password" class="input-field" name="password" type="password">

                <svg id="togglePassword" class="eye-icon" viewBox="0 0 24 24">
                    <path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 
                    11-7-4-7-11-7zm0 12c-2.8 0-5-2.2-5-5s2.2-5 
                    5-5 5 2.2 5 5-2.2 5-5 
                    5zm0-8c-1.7 0-3 1.3-3 
                    3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"/>
                </svg>
            </div>

            <button class="btn" type="submit">Login</button>
        </form>

    </div>
</div>

<script>
    const passField = document.getElementById("passwordField");
    const toggle = document.getElementById("togglePassword");

    toggle.addEventListener("click", () => {
        const hidden = passField.type === "password";
        passField.type = hidden ? "text" : "password";

        toggle.innerHTML = hidden
            ? `<path d="M1 1l22 22M12 5c-7 0-11 7-11 7s4 7 
            11 7c3 0 5.5-1.1 7.5-2.7" />`
            : `<path d="M12 5c-7 0-11 7-11 7s4 7 11 7 
            11-7 11-7-4-7-11-7z" />`;
    });
</script>

</body>
</html>