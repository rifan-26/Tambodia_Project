<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Tambodia</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    * { box-sizing: border-box;}
    body, html {
      margin: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background: #fff;
      overflow-x: hidden;
    }
    .container {
      display: flex;
      min-height: 100vh; /* Changed from 90vh to 100vh */
      align-items: center;
      justify-content: space-between;
      padding: 2rem 5vw;
      /* Updated background properties */
      background: url("{{ asset('img/Group 1.svg') }}") no-repeat right center;
      background-size: contain; /* Changed from fixed size to cover */
      background-attachment: fixed; /* Optional: keeps background fixed during scroll */
      
    }
    .left {
      max-width: 50vw;
      min-width: 320px;
      padding-right: 2rem;
    }
    .heading {
      font-weight: 700;
      font-size: 3rem;
      color: #465ea6;
      margin: 0 0 0.5rem 0;
      line-height: 1.1;
    }
    .highlight-green { color: #45b649; }

    svg.login-illustration, .login-illustration {
      width: 100%;
      max-width: 420px;
      height: auto;
      margin-top: 1rem;
      display: block;
      user-select: none;
    }

    .right {
      flex: 1;
      position: relative;
      max-width: 390px;
      min-width: 300px;
    }

    .login-card {
      background: rgba(255 255 255 / 0.2);
      border-radius: 28px;
      padding: 3rem 3.5rem;
      box-shadow: 0 8px 32px rgba(70, 94, 166, 0.22);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(255 255 255 / 0.18);
      color: #465ea6;
      display: flex;
      flex-direction: column;
      gap: 1.8rem;
    }

    .login-header {
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1rem;
      user-select: none;
    }

    .input-group { display: flex; flex-direction: column; }

    input[type="text"], input[type="password"] {
      border: none;
      background: #f6f8fc;
      border-radius: 6px;
      padding: 0.8rem 1.25rem;
      font-size: 1rem;
      outline-offset: -2px;
      color: #465ea6;
      border-left: 6px solid transparent;
      transition: border-color 0.3s ease;
    }

    input::placeholder {
      color: #8992aa;
      font-weight: 500;
    }

    input:focus {
      border-left-color: #45b649;
      background: #edf5ed;
    }

    button.login-btn {
      align-self: flex-end;
      background-color: #45b649;
      border: none;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      padding: 0.75rem 1.8rem;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button.login-btn:hover {
      background-color: #3ea142;
    }

    .error-message {
      background-color: #ffe5e5;
      border: 1px solid #ffb3b3;
      color: #d8000c;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      font-size: 0.95rem;
    }

    @media (max-width: 850px) {
      .container {
        flex-direction: column;
        align-items: center;
        padding: 2rem 2rem;
        background: none;
      }
      .left, .right {
        max-width: 100%;
        min-width: auto;
      }
      .left { text-align: center; }
      .login-card {
        width: 100%;
        max-width: 380px;
        margin-top: 3rem;
      }
      .heading { font-size: 2.25rem; }
      .login-illustration {
        max-width: 320px;
        margin: 1.25rem auto 0 auto;
      }
    }
    .sr-only {
      position: absolute !important;
      width: 1px !important;
      height: 1px !important;
      padding: 0 !important;
      margin: -1px !important;
      overflow: hidden !important;
      clip: rect(0,0,0,0) !important;
      border: 0 !important;
    }
  </style>
</head>
<body>
  <!-- main container -->
  <div class="container" role="main" aria-label="Login page for Tambodia">
    <section class="left">
      <h1 class="heading" aria-label="Selamat Datang">SELAMAT DATANG!</h1>
      <img src="{{ asset('img/image_4k 1.svg') }}" alt="Ilustrasi Login" class="login-illustration" />
      <h2 class="heading" aria-label="Di Tambodia" style="margin-top:0.6rem;">
        DI, <span class="highlight-green">TAMBODIA!</span>
      </h2>
    </section>

    <section class="right" aria-label="Login form">
      <form method="POST" action="{{ route('login') }}" class="login-card" aria-describedby="login-instruction" novalidate>
        @csrf

        <div class="login-header" id="login-instruction" aria-live="polite">
          YUK, <span class="highlight-green">LOGIN!</span>
        </div>

        @if ($errors->any())
          <div class="error-message">
            {{ $errors->first() }}
          </div>
        @endif

        <label for="email" class="sr-only">Email</label>
        <input type="text" name="email" id="email" placeholder="EMAIL" autocomplete="username" value="{{ old('email') }}" required />

        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" placeholder="PASSWORD" autocomplete="current-password" required />

        <button type="submit" class="login-btn" aria-label="Login to your account">LOGIN</button>
      </form>
    </section>
  </div>
</body>
</html>