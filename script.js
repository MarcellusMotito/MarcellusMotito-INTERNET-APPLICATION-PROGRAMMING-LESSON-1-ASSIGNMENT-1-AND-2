document.addEventListener('DOMContentLoaded', () => {
    const formWrapper = document.getElementById('authForms');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const forgotForm = document.getElementById('forgotForm');
    const logoutBtn = document.getElementById('logout');

    function toggleForms() {
        formWrapper.classList.toggle('active');
        formWrapper.classList.remove('show-forgot');
    }

    window.showForgotPassword = function() {
        formWrapper.classList.add('show-forgot');
    }

    window.showLogin = function() {
        formWrapper.classList.remove('show-forgot');
    }

    function showMainContent() {
        formWrapper.style.display = 'none';
        document.getElementById('mainContent').style.display = 'block';
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
            await fetch('logout.php');
            formWrapper.style.display = 'block';
            document.getElementById('mainContent').style.display = 'none';
        } catch (error) {
            console.error('Logout error:', error);
        }
    });
});