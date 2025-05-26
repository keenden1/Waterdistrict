<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="split-form">
    <div class="image-side">
        <img src="{{ asset('logo/logo.png') }}" alt="Villasis Water District" class="image-side-img">
        <h2>VILLASIS WATER DISTRICT</h2>
        <p>Please Fill-up Carefully!</p>
    </div>
    <div class="form-side">
        <h2 style="text-align: center;">Admin Register</h2>
        @if(session('error'))
    <div class="text-danger">
        {{ session('error') }}
    </div>
        @endif
        <form method="POST" action="{{ route('Register-Admin-Post') }}">
    @csrf

    <!-- Name Field -->
    <div style="display: flex; gap: 10px; align-items: center;">
    <input type="text" name="fname" placeholder="First Name" value="{{ old('fname') }}" required>
    <input type="text" name="mname" placeholder="Middle Name" value="{{ old('mname') }}"  maxlength="1">
    <input type="text" name="lname" placeholder="Last Name" value="{{ old('lname') }}"  required>
    </div>

   
    @error('fname')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    @error('mname')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    @error('lfname')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <input type="number" name="employee_id" id="employee_id"  placeholder="Employee ID" value="{{ old('employee_id') }}" required>
    @error('employee_id')
        <span class="text-danger">{{ $message }}</span>
    @enderror


    <input type="text" name="position" placeholder="Position" value="{{ old('position') }}" required>
    @error('position')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <!-- Email Field -->
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <!-- Password Field -->
    <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fas fa-eye-slash" id="toggle-password"></i>
    </div>
    @error('password')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <!-- Confirm Password Field -->
    <div class="password-container">
        <input type="password" name="password_confirmation" id="confirm-password" placeholder="Confirm Password" required>
        <i class="fas fa-eye-slash" id="toggle-confirm-password"></i>
    </div>
    @error('password_confirmation')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <input type="hidden" name="role"  id="role" value="user">
    <input type="hidden" name="status"  id="status" value="pending">
    <button type="submit" class="login-button">Register</button>
</form>
        <p class="link-text">Already have an account? <a href="{{ url('/Admin') }}">Sign In</a></p>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    
    togglePassword.addEventListener('click', () => {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        togglePassword.classList.toggle('fa-eye-slash');
        togglePassword.classList.toggle('fa-eye');
    });

    const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
    const confirmPasswordField = document.getElementById('confirm-password');
    
    toggleConfirmPassword.addEventListener('click', () => {
        const type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        confirmPasswordField.type = type;
        toggleConfirmPassword.classList.toggle('fa-eye-slash');
        toggleConfirmPassword.classList.toggle('fa-eye');
    });
</script>
</body>
<style>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

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
        max-width: 870px;
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
    .image-side h2,.image-side p{
        z-index: 3;
        
    }
    .image-side h2{
        padding-top: 250px;
    }

    .image-side-img {
        position: absolute;
        top: 5%;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        max-width: 300px; 
        object-fit: contain; 
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

        .image-side h2{
            padding-top: 130px;
        }

        .image-side-img {
            position: absolute;
            top: 5%;
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

</style>
<script>
      document.getElementById('employee_id').addEventListener('input', function(e) {
    // Ensure input value doesn't exceed 2 digits
    if (this.value.length > 2) {
      this.value = this.value.slice(0, 10);
    }
  });
</script>
 <script>
  const form = document.querySelector('form');
  const loginBtn = document.getElementById('login-button');

  form.addEventListener('submit', function(e) {
    // Prevent double submits
    if (loginBtn.disabled) return;

    // Disable the button
    loginBtn.disabled = true;

    // Swap its inner HTML to a spinner + text
    loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

    // (The form will now submit; if you were doing AJAX, you'd do it here)
  });
</script>
</html>
