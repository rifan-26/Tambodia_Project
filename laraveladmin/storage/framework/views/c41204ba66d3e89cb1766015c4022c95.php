<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Tambodia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fb;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .left {
            width: 50%;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
        }

        .left h1 {
            font-size: 40px;
            color: #384a8c;
            margin: 0;
        }

        .left h2 {
            font-size: 32px;
            color: #31b44c;
            margin: 0;
        }

        .left img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }

        .right {
            width: 50%;
            background: #e5e8fd;
            background-image: url("<?php echo e(asset('images/bgpattern.png')); ?>");
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
        }

        .login-card h3 {
            margin: 0 0 20px;
            font-size: 24px;
            color: #384a8c;
        }

        .login-card h3 span {
            color: #31b44c;
        }

        .login-card input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .login-card button {
            width: 100%;
            padding: 12px;
            background-color: #31b44c;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .login-card button:hover {
            background-color: #2ba141;
        }
    </style>
</head>
<body>

    <div class="left">
        <h1>SELAMAT DATANG!</h1>
        <h2>DI, TAMBODIA!</h2>
        <img src="<?php echo e(asset('images/Login.png')); ?>" alt="Welcome Illustration">
    </div>

    <div class="right">
        <div class="login-card">
            <h3>YUK, <span>LOGIN!</span></h3>
            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="text" name="username" placeholder="USERNAME" required>
                <input type="password" name="password" placeholder="PASSWORD" required>
                <button type="submit">LOGIN</button>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH D:\laragon\www\laraveladmin\resources\views/home.blade.php ENDPATH**/ ?>