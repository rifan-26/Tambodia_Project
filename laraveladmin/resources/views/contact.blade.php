<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('path/to/your/pattern.jpg') repeat;
        }
        .container {
            display: flex;
            background: #f0f4f8;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .welcome-section {
            padding: 40px;
            text-align: center;
            background: #e9f0f7;
            width: 400px;
        }
        .welcome-section h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .welcome-section h2 {
            color: #27ae60;
            font-size: 2em;
            margin: 0;
        }
        .welcome-section img {
            max-width: 100%;
            height: auto;
        }
        .login-section {
            padding: 40px;
            background: #ecf0f3;
            width: 300px;
            text-align: center;
        }
        .login-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .login-section input {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #fff;
        }
        .login-section button {
            width: 100%;
            padding: 10px;
            background: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-section button:hover {
            background: #219653;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h1>SELAMAT DATANG!</h1>
            <h2>DI, TAMBOIA!</h2>
            <!-- Ganti dengan path gambar yang sesuai -->
            <img src="path/to/your/welcome-image.jpg" alt="Welcome Image">
        </div>
        <div class="login-section">
            <h3>YUK, LOGIN!</h3>
            <form method="POST" action="/login">
                @csrf
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>