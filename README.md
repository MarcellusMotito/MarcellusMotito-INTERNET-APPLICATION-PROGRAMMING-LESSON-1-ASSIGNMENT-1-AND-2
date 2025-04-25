# Secure Login System - Operating Instructions

This login system is developed using HTML, JavaScript, and PHP, implementing session-based authentication, password hashing, secure cookies, and protection against SQL Injection attacks. The system is designed to run on XAMPP with the project files placed inside the `htdocs` folder.

---

## Setup and Running the System 

1. **Install XAMPP**

   Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/).

2. **Place Project Files**

   Copy all project files (PHP, JS, and related files) into a folder inside the `htdocs` directory of your XAMPP installation. For example:

   ```
   C:\xampp\htdocs\your_project_folder
   ```

3. **Start Apache and MySQL**

   Open the XAMPP Control Panel and start the Apache and MySQL services.

4. **Create Database and Table**

   - Open `http://localhost/phpmyadmin` in your browser.
   - Create a database named `fildberg_db`.
   - Create a `users` table with the following structure:

     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       reset_token VARCHAR(255) DEFAULT NULL,
       token_expiry DATETIME DEFAULT NULL
     );
     ```

5. **Configure Database Connection**

   The database connection is configured in `config.php`. Adjust the host, username, password, and database name if necessary.

---

## Using the System

- **Sign Up**

  Navigate to `http://localhost/your_project_folder/index.php`. Use the Sign Up form to create a new account. Passwords are securely hashed before storage.

- **Login**

  Use the Login form to authenticate. On success, a session is created and a secure cookie is set.

- **Forgot Password**

  Use the Forgot Password form to request a password reset. The system generates a secure reset token.

- **Logout**

  Use the Logout link to end your session securely.

---

## Security Features

- **Session-based Authentication:** PHP sessions track logged-in users.
- **Password Hashing:** Passwords are hashed using PHP's `password_hash()` function.
- **Secure Cookies:** Cookies are set with `HttpOnly` and `Secure` flags.
- **SQL Injection Prevention:** All database queries use prepared statements.
- **Password Reset Tokens:** Secure random tokens with expiry for password resets.

---

## Notes

- Ensure Apache is configured for HTTPS to fully utilize secure cookies.
- Extend password reset functionality to send emails with reset links.
- Review and customize UI and content as needed.

---

## Summary

This system demonstrates a secure login implementation using standard web technologies and best practices for authentication and security. It is intended for educational purposes and can be extended for production use.
