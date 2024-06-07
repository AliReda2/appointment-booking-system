<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgb(207 230 255);
            z-index: 1;
            display: none;
        }

        .login-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 2;
            display: none;
        }

        .login-form h2 {
            margin-top: 0;
        }

        .login-form label {
            display: block;
            margin: 10px 0 5px;
        }

        .login-form input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .login-form button {
            margin-top: 10px;
            padding: 10px;
            width: 100%;
            background: #007BFF;
            border: none;
            color: white;
            cursor: pointer;
        }

        .login-form button:hover {
            background: #0056b3;
        }

        .error-message {
            color: red;
            display: none;
        }
    </style>
</head>

<body>
    <div id="overlay" class="overlay"></div>
    <div id="loginForm" class="login-form">
        <h2>Login</h2>
        <form id="loginFormElement">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p id="errorMessage" class="error-message"></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginFormElement = document.getElementById('loginFormElement');
            if (loginFormElement) {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('loginForm').style.display = 'block';

                loginFormElement.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const username = document.getElementById('username').value;
                    const password = document.getElementById('password').value;

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'admin-login.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    window.location.href = 'admin.php';
                                } else {
                                    const errorMessage = document.getElementById('errorMessage');
                                    errorMessage.textContent = response.message;
                                    errorMessage.style.display = 'block';
                                }
                            } catch (e) {
                                console.error("Failed to parse JSON response:", xhr.responseText);
                            }
                        }
                    };
                    xhr.send(`username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`);
                });
            }
        });
    </script>
</body>

</html>