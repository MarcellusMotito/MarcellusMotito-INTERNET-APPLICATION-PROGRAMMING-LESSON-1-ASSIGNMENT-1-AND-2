<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FILDBERG INSTITUTION</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(45deg, #1a1a2e, #16213e);
            overflow-x: hidden;
        }

        .background-3d {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url('https://source.unsplash.com/random/1920x1080?abstract') no-repeat center;
            background-size: cover;
            transform: translateZ(-1px) scale(2);
            opacity: 0.2;
            z-index: -1;
        }

        .container {
            position: relative;
            width: 100%;
            min-height: 100vh; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            position: relative;
            width: 800px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
        }

        .form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(10px);
            z-index: -1;
        }

        .login-form, .signup-form, .forgot-form {
            position: absolute;
            width: 50%;
            height: 100%;
            padding: 40px;
            transition: all 0.5s ease;
        }

        .login-form {
            left: 0;
        }

        .signup-form {
            right: 0;
            transform: translateX(100%);
        }

        .forgot-form {
            left: 0;
            transform: translateX(-100%);
        }

        .overlay-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            padding: 40px;
            background: linear-gradient(45deg, #e94560, #0f3460);
            color: white;
            transition: all 0.5s ease;
        }

        .overlay-left { right: 0; }
        .overlay-right { left: 0; transform: translateX(-100%); }

        .active .signup-form { transform: translateX(0); }
        .active .login-form { transform: translateX(-100%); }
        .active .overlay-left { transform: translateX(-100%); }
        .active .overlay-right { transform: translateX(0); }

        .show-forgot .forgot-form { transform: translateX(0); }
        .show-forgot .login-form { transform: translateX(-100%); }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 16px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.9);
            opacity: 1;
        }

        button {
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: #e94560;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        button:hover {
            transform: scale(1.05);
        }

        h2 {
            color: white;
            margin-bottom: 20px;
        }

        .signup-link, .login-link, .back-link {
            color: white;
            cursor: pointer;
        }

        .signup-link span, .login-link span, .back-link span {
            color: #e94560;
            font-weight: bold;
        }

        .main-content {
            width: 100%;
            padding: 80px 40px 40px 40px;
            color: white;
            display: none;
        }

        header {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 40px;
        }

        nav ul {
            display: flex;
            justify-content: space-around;
            list-style: none;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
        }

        section {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .error-message {
            color: #ff4444;
            font-size: 12px;
            position: absolute;
            bottom: -15px;
            left: 15px;
            display: none;
        }
    </style>
</head>
<body>
    <?php
    
    if (isset($_SESSION['user_id'])) {
        echo '<style>#authForms { display: none; } #mainContent { display: block; }</style>';
    }
    ?>
    <div class="background-3d"></div>
    <div class="container">
        <div class="form-wrapper" id="authForms">
            <div class="login-form">
                <h2>Login</h2>
                <form id="loginForm" method="POST" action="login.php">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email" required autocomplete="email">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <span class="error-message"></span>
                    </div>
                    <button type="submit" class="submit-btn">Login</button>
                    <a href="#" class="forgot-pass" onclick="showForgotPassword()">Forgot Password?</a>
                    <p class="signup-link">New here? <span onclick="toggleForms()">Sign Up</span></p>
                </form>
            </div>

            <div class="signup-form">
                <h2>Sign Up</h2>
                <form id="signupForm" method="POST" action="signup.php">
                    <div class="input-group">
                        <input type="text" name="fullname" placeholder="Full Name" required autocomplete="name">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email" required autocomplete="email">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                        <span class="error-message"></span>
                    </div>
                    <button type="submit" class="submit-btn">Sign Up</button>
                    <p class="login-link">Have account? <span onclick="toggleForms()">Login</span></p>
                </form>
            </div>

            <div class="overlay-panel overlay-left">
                <h2>Hello, User!</h2>
                <p>Enter your details to join us</p>
            </div>
            <div class="overlay-panel overlay-right">
                <h2>Hello, User!</h2>
                <p>Welcome back to Fildberg</p>
            </div>

            <div class="forgot-form" style="display: none;">
                <h2>Reset Password</h2>
                <form id="forgotForm" method="POST" action="forgot.php">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <span class="error-message"></span>
                    </div>
                    <button type="submit" class="submit-btn">Reset Password</button>
                    <p class="back-link"><span onclick="showLogin()">Back to Login</span></p>
                </form>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            <header>
                <h1>FILDBERG INSTITUTION</h1>
                <nav>
                    <ul>
                        <li><a href="#departments">Departments</a></li>
                        <li><a href="#contact">Contact Info</a></li>
                        <li><a href="#courses">Courses Offered</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#" id="logout">Logout</a></li>
                    </ul>
                </nav>
            </header>
            <section id="departments">
                <h2>Departments</h2>
                <p>Content about various departments...</p>
            </section>
            <section id="contact">
                <h2>Contact Info</h2>
                <p>Email: info@fildberg.edu | Phone: +254123456789</p>
            </section>
            <section id="courses">
                <h2>Courses Offered</h2>
                <p>List of courses available...</p>
            </section>
            <section id="about">
                <h2>About</h2>
                <p>About Fildberg Institution...</p>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formWrapper = document.getElementById('authForms');
            const signupForm = document.getElementById('signupForm');
            const loginForm = document.getElementById('loginForm');
            const forgotForm = document.getElementById('forgotForm');
            const logoutBtn = document.getElementById('logout');

            window.toggleForms = function() {
                formWrapper.classList.toggle('active');
                console.log('Toggle clicked');
            };

            window.showForgotPassword = function() {
                formWrapper.classList.add('show-forgot');
                formWrapper.classList.remove('active');
            };

            window.showLogin = function() {
                formWrapper.classList.remove('show-forgot');
                formWrapper.classList.remove('active');
            };

            function showMainContent() {
                formWrapper.style.display = 'none';
                document.getElementById('mainContent').style.display = 'block';
            }

            function showAuthForms() {
                formWrapper.style.display = 'block';
                document.getElementById('mainContent').style.display = 'none';
            }

            function showError(form, message) {
                const errorElement = form.querySelector('.error-message');
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                setTimeout(() => errorElement.style.display = 'none', 3000);
            }

            signupForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(signupForm);

                try {
                    const response = await fetch('signup.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.success) {
                        showMainContent();
                    } else {
                        showError(signupForm, data.message);
                    }
                } catch (error) {
                    console.error('Signup error:', error);
                    showError(signupForm, 'An error occurred. Please try again.');
                }
            });

            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(loginForm);

                try {
                    const response = await fetch('login.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.success) {
                        showMainContent();
                    } else {
                        showError(loginForm, data.message);
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    showError(loginForm, 'An error occurred. Please try again.');
                }
            });

            forgotForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(forgotForm);

                try {
                    const response = await fetch('forgot.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.success) {
                        alert(data.message);
                        showLogin();
                    } else {
                        showError(forgotForm, data.message);
                    }
                } catch (error) {
                    console.error('Forgot password error:', error);
                    showError(forgotForm, 'An error occurred. Please try again.');
                }
            });

            logoutBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                try {
                    const response = await fetch('logout.php', {
                        method: 'POST'
                    });
                    const data = await response.json();
                    if (data.success) {
                        showAuthForms();
                    } else {
                        console.error('Logout failed:', data.message);
                    }
                } catch (error) {
                    console.error('Logout error:', error);
                    showAuthForms();
                }
            });
        });
    </script>
</body>
</html>