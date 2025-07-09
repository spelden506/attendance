<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #e6e2de;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      box-sizing: border-box;
    }

    .login-container {
      display: grid;
      grid-template-columns: 50% 50%;
      width: 100%;
      max-width: 950px;
      height: 620px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .login-form-panel {
      padding: 50px 60px;
      background-color: #f5f3f1;
      display: flex;
      flex-direction: column;
    }

    .logo-group {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 40px;
    }

    .logo-icon {
      height: 60px;
      width: auto;
    }

    .logo-text {
      font-size: 22px;
      font-weight: 700;
      color: #1d4ed8;
      line-height: 1.2;
    }

    .form-content {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .input-group {
      margin-bottom: 25px;
    }

    .input-group label {
      display: block;
      font-size: 14px;
      font-weight: 500;
      color: #333;
      margin-bottom: 8px;
    }

    .input-group input {
      width: 100%;
      padding: 14px 15px;
      border: 1px solid #dcdcdc;
      border-radius: 10px;
      background-color: #fff;
      font-size: 15px;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    .input-group input::placeholder {
      color: #aaa;
    }

    .input-group input:focus {
      outline: none;
      border-color: #dcb95b;
      box-shadow: 0 0 0 2px rgba(220, 185, 91, 0.3);
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 45px;
    }

    input::-ms-reveal,
    input::-ms-clear {
      display: none;
    }

    input[type="password"]::-webkit-credentials-auto-fill-button {
      visibility: hidden;
      display: none !important;
      pointer-events: none;
      position: absolute;
      right: 0;
    }

    .toggle-icon {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      font-size: 18px;
      color: #666;
      cursor: pointer;
      user-select: none;
    }

    .signin-btn {
      width: 100%;
      padding: 15px;
      background-color: #dcb95b;
      border: none;
      border-radius: 10px;
      color: #40300a;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 15px;
      transition: background-color 0.3s ease;
    }

    .signin-btn:hover {
      background-color: #cda94a;
    }

    .form-footer {
      display: flex;
      justify-content: space-between;
      margin-top: auto;
      padding-top: 20px;
    }

    .form-footer a {
      font-size: 14px;
      color: #666;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }

    .right-panel {
      background-size: cover;
      background-position: center;
    }

    @media (max-width: 900px) {
      .login-container {
        grid-template-columns: 1fr;
        max-width: 500px;
        height: auto;
      }

      .right-panel {
        display: none;
      }

      .login-form-panel {
        padding: 40px;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-form-panel">
    <div class="logo-group">
      <img src="{{ asset('images/logo1.png') }}" alt="YangKhor Logo" class="logo-icon">
      <span class="logo-text">YangKhor Private Limited</span>
    </div>

    <div class="form-content">
      {{-- Validation Errors --}}
      @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Session Message --}}
      @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
          {{ session('status') }}
        </div>
      @endif

      {{-- Laravel Login Form --}}
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <span class="toggle-icon" id="togglePassword">👁️</span>
          </div>
        </div>

        <div class="form-footer" style="margin-top: 10px;">
          <label style="font-size: 14px;">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            Remember me
          </label>

          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot Password?</a>
          @endif
        </div>

        <button type="submit" class="signin-btn">Log In</button>
      </form>
    </div>
  </div>

  <div class="right-panel" style="background-image: url('{{ asset('images/login_image.jpeg') }}');"></div>
</div>

<!-- Toggle Password JS -->
<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
  });
</script>

</body>
</html>
