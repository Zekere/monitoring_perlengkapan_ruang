<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      overflow: hidden;
      background: url('https://images.unsplash.com/photo-1662452996692-11c2439432fa?q=80&w=1471&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center;
      background-size: cover;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.4);
    }

    .login-container {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border-radius: 24px;
      padding: 50px 45px;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37),
                  inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.12);
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-title {
      color: #ffffff;
      font-weight: 600;
      font-size: 34px;
      margin-bottom: 10px;
      text-align: center;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
      letter-spacing: -0.5px;
    }

    .login-subtitle {
      color: rgba(255, 255, 255, 0.7);
      font-size: 14px;
      text-align: center;
      margin-bottom: 35px;
      font-weight: 300;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-label {
      color: rgba(255, 255, 255, 0.95);
      font-weight: 500;
      margin-bottom: 10px;
      display: block;
      font-size: 14px;
      letter-spacing: 0.3px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1.5px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      padding: 14px 18px;
      color: #ffffff;
      font-size: 15px;
      width: 100%;
      transition: all 0.3s ease;
      font-weight: 400;
    }

    .form-control:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(38, 102, 127, 0.6);
      box-shadow: 0 0 0 4px rgba(38, 102, 127, 0.15);
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.5);
      font-weight: 300;
    }

    /* Options */
    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }

    /* Button */
    .btn-login {
      background: linear-gradient(135deg, #26667F 0%, #1a4d5f 100%);
      color: #ffffff;
      border: none;
      border-radius: 12px;
      padding: 15px;
      font-weight: 600;
      font-size: 16px;
      width: 100%;
      margin-top: 28px;
      transition: all 0.3s ease;
      box-shadow: 0 6px 20px rgba(38, 102, 127, 0.4);
      cursor: pointer;
      letter-spacing: 0.5px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(38, 102, 127, 0.5);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .form-check {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-check-input {
      width: 18px;
      height: 18px;
      background: rgba(255, 255, 255, 0.15);
      border: 1.5px solid rgba(255, 255, 255, 0.3);
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .form-check-input:checked {
      background-color: #26667F;
      border-color: #26667F;
    }

    .form-check-label {
      color: rgba(255, 255, 255, 0.85);
      font-size: 13px;
      font-weight: 400;
      cursor: pointer;
    }

    .forgot-password {
      color: rgba(255, 255, 255, 0.85);
      font-size: 13px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 400;
    }

    .forgot-password:hover {
      color: #ffffff;
    }

    /* Responsive */
    @media (max-width: 576px) {
      .login-card {
        padding: 40px 30px;
      }
      .login-title {
        font-size: 28px;
      }
      .toggle-option {
        padding: 10px 24px;
        font-size: 13px;
      }
    }

    .btn-pengaduan {
  background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
  margin-top: 14px;
  box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
}

.btn-pengaduan:hover {
  box-shadow: 0 8px 25px rgba(108, 117, 125, 0.5);
}

  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <h1 class="login-title">Inventaris Barang</h1>
      <p class="login-subtitle">Ditjen Cipta Karya</p>
      
   <form method="POST" action="/login">
  @csrf

  <div class="form-group">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" placeholder="Email" required>
  </div>

  <div class="form-group">
    <label class="form-label">Password</label>
    <input class="form-control" type="password" name="password" placeholder="Password" required>
  </div>

  <button class="btn-login" type="submit">Login</button>

<a href="{{ route('pengaduan.create') }}" 
   class="btn-login btn-pengaduan" 
   style="text-decoration: none; display: inline-block;">
  🛠️ Pengaduan Kerusakan Inventaris
</a>



  {{-- ✅ ERROR LOGIN YANG BENAR --}}
  @if ($errors->any())
    <div style="margin-top:15px; color:#ffb3b3; font-size:14px;">
      {{ $errors->first() }}
    </div>
  @endif
</form>


    </div>
  </div>
</body>
</html>