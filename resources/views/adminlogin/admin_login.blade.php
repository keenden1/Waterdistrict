<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
    <title>Admin-Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="split-form">
    <div class="image-side">
        <h2 class="text-1">Human Resources System</h2>
        <img src="{{ asset('logo/logo.png') }}" alt="Villasis Water District" class="image-side-img">
        <h2 class="text-2">VILLASIS WATER DISTRICT</h2>
        <p>Welcome Back!</p>
    </div>
    <div class="form-side">
        <h1 style="text-align: center; margin-bottom:10px;text-transform: uppercase; letter-spacing: 2px; font-weight: bold; ">ADMIN</h1>
        @if(session('error'))
    <div class="text-danger"  id="error-message">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="text-success" id="success-message">
        {{ session('success') }}
    </div>
    @endif
    <form method="POST" action="{{ route('Admin-Login') }}" id="admin-login-form">
        @csrf

        <!-- Email Field -->
        <input type="email" name="email" placeholder="Email" required>
        @error('email')
            <span class="text-danger" id="error-message">{{ $message }}</span>
        @enderror

        <!-- Password Field -->
        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fas fa-eye-slash" id="toggle-password"></i> 
        </div>
        @error('password')
            <span class="text-danger" id="error-message">{{ $message }}</span>
        @enderror

         <div style="width:50px; position:relative; margin: 10px 0;">
        <input type="checkbox" id="admin_remember" name="admin_remember" value="1" >
        <label for="admin_remember" style="position:absolute; left:50px; margin-top:2px;">Remember&nbsp;Me</label>
        </div>

        <button type="submit" id="admin-login-button">Login</button>
    </form>
   @if ($count == 0)
    <p class="link-text">
        Doesn't have an account?
        <a href="{{ url('/Admin-Register-Page') }}">Register</a>
    </p>
@endif

        <p class="forgot-password-text"><a href="{{ url('/Admin-Change-Password') }}">Forgot Password?</a></p>
    </div>
</div>
<!-- <a href="{{ route('logout') }}" class="btn btn-danger"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form> -->

<script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    togglePassword.addEventListener('click', () => {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        togglePassword.classList.toggle('fa-eye-slash'); 
        togglePassword.classList.toggle('fa-eye'); 
    });
</script>
</body>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        justify-content: center; 
        align-items: center; 
        padding: 2rem;
        background: #f0f2f5;
    }

    .split-form {
        display: flex;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .split-form .image-side {
        flex: 1;
        background: linear-gradient(5deg, #0000FF, #1E3A8A, #E6E6FA);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
    }
    .text-2,.image-side p{
        z-index: 3;
    }
    .text-1{
        margin-top: -15px;
        font-weight: bold;
        color: #1E3A8A;
    }

    .text-2{
        margin-top: 30px;
    }
    .image-side-img {
        position: absolute;
        top: 14%;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        max-width: 300px; 
        object-fit: contain; 
    }
    .text-2{
        padding-top: 250px;
    }
    .split-form .form-side {
        flex: 1;
        padding: 3rem;
    }

    .split-form input {
        width: 100%;
        padding: 1rem;
        margin: 0.5rem 0;
        border: none;
        border-bottom: 2px solid #eee;
        outline: none;
        transition: border-color 0.3s;
    }

    .split-form input:focus {
        border-bottom-color: rgb(64, 138, 224);
    }

    .split-form button {
        width: 100%;
        padding: 1rem;
        margin-top: 1.5rem;
        background: rgb(64, 138, 224);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: bold;
        transition: transform 0.3s;
    }

    .split-form button:hover {
        transform: translateY(-2px);
    }

    .password-container {
        position: relative;
    }

    .password-container i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .link-text {
        margin-top: 1rem;
        text-align: center;
    }

    .link-text a {
        color: rgb(64, 138, 224);
        text-decoration: none;
    }

    .link-text a:hover {
        text-decoration: underline;
    }
    .forgot-password-text {
        text-align: center;
        margin-top: 1rem;
    }

    .forgot-password-text a {
        color: rgb(64, 138, 224);
        text-decoration: none;
    }

    .forgot-password-text a:hover {
        text-decoration: underline;
    }
    

    @media (max-width: 768px) {
        .split-form {
            flex-direction: column; 
        }
        .split-form .image-side {
            flex: none;
            padding: 1.5rem;
        }

        .split-form .form-side {
            padding: 2rem;
        }
        .text-2{
            margin-top: -100px;
        }
        .image-side-img {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translateX(-50%);
            width: 70%;
            max-width: 150px; 
            object-fit: contain; 
        }
    }
    .text-danger {
    color: #dc3545; /* Bootstrap red color */
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    display: block;
}
.text-success {
    color:rgb(53, 220, 128); /* Bootstrap red color */
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    display: block;
}
</style>
<script>
        // Hide the success message after 5 seconds
        setTimeout(function() {
            var message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000); // 5000ms = 5 seconds

        setTimeout(function() {
            var message = document.getElementById('error-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000); 

    </script>
   <script>
  const form = document.querySelector('#admin-login-form');
  const loginBtn = document.getElementById('admin-login-button');
  const emailInput = document.querySelector('input[name="email"]');
  const rememberCheckbox = document.getElementById('admin_remember');

  // On page load, prefill email if saved
  document.addEventListener('DOMContentLoaded', () => {
    const savedEmail = localStorage.getItem('savedEmail');
    if (savedEmail) {
      emailInput.value = savedEmail;
      rememberCheckbox.checked = true;
    }
  });

  form.addEventListener('submit', function(e) {
    // Prevent double submits
    if (loginBtn.disabled) return;

    // Save or remove email based on checkbox
    if (rememberCheckbox.checked) {
      localStorage.setItem('savedEmail', emailInput.value);
    } else {
      localStorage.removeItem('savedEmail');
    }

    // Disable the button
    loginBtn.disabled = true;

    // Swap its inner HTML to a spinner + text
    loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

    // (The form will now submit; if you were doing AJAX, you'd do it here)
  });
</script>
</html>
