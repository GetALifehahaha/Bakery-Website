<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #1e1e1e;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .login-container {
            background-color: #717171;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .login-title {
            margin-bottom: 30px;
            color: white;
            font-size: 36px;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background-color: white;
            box-sizing: border-box;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon input {
            padding-right: 40px;
        }
        
        .input-icon i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .btn-login {
            width: 100%;
            background-color: #2b2b2b;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-login:hover {
            background-color: #222;
        }
        
        .register-link {
            margin-top: 15px;
            color: white;
            font-size: 14px;
        }
        
        .register-link a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        
        <form action="bakeryAdmin.html" method="post">
            <div class="form-group input-icon">
                <input type="email" class="form-control" placeholder="Email">
                <i>✉️</i>
            </div>
            
            <div class="form-group input-icon">
                <input type="password" class="form-control" placeholder="Password">
                <i>🔒</i>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
            
            <div class="register-link">
                Don't have an account? <a href="#">Register</a>
            </div>
        </form>
    </div>

    <script src="Login.js"></script>
</body>
</html>