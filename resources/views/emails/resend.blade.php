@extends('layout.layoutuser')
@section('title', 'Account Verification')
@section('header_title', "VERIFY EMAIL")
@section('content')

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            A fresh verification link has been sent to your email address.
        </div>
    @endif

    <div class="container">
        <div class="verification-card">
            <h2>Verify Your Email Address</h2>

            <p class="info-text">Before proceeding, please check your email for a verification link. If you did not receive the email, you can request another one.</p>

            @php
                // Calculate remaining time before the user can resend the email
                $remainingTime = session('last_resend_time') ? 5 - now()->diffInMinutes(session('last_resend_time')) : 0;
            @endphp

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf

                <!-- Hidden input to store the remaining time (in minutes) -->
                <input type="hidden" id="remainingTime" value="{{ $remainingTime }}">

                @if ($remainingTime > 0)
                    <p class="timer-info">You can request a new verification link in <span id="timer">{{ $remainingTime }} minutes</span>.</p>
                    <button type="button" id="resendButton" class="request-link-btn" disabled>Request another verification link</button>
                @else
                    <button type="submit" id="resendButton" class="request-link-btn">Request another verification link</button>
                @endif
            </form>
        </div>
    </div>

    <style>
        /* Basic container for centering the content */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }

        /* Card Style */
        .verification-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Header */
        .verification-card h2 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Info text */
        .info-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        /* Button */
        .request-link-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .request-link-btn:hover {
            background-color: #218838;
        }

        /* Success message */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Timer info */
        .timer-info {
            font-size: 1rem;
            color: #ff6f00;
        }

        /* Disabled button style */ 
        .request-link-btn:disabled {
            background-color: #cccccc; /* Light grey */
            color: #777777;  /* Dark grey text */
            cursor: not-allowed;  /* Change cursor to indicate it's disabled */
        }
    </style>

    <script>
        // Get the remaining time from the hidden input
        var remainingTime = document.getElementById('remainingTime').value * 60;  // 60 to Convert minutes to seconds
        var timerElement = document.getElementById('timer');
        var resendButton = document.getElementById('resendButton');

        if (remainingTime > 0) {
            // Disable the resend button while the timer is running
            resendButton.disabled = true;

            // Start countdown timer
            setInterval(function() {
                if (remainingTime <= 0) {
                    resendButton.disabled = false;
                    timerElement.innerHTML = 'Now!';
                    return;
                }

                let minutes = Math.floor(remainingTime / 60);
                let seconds = remainingTime % 60;
                timerElement.innerHTML = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
                remainingTime--;
            }, 1000);
        } else {
            // If there's no remaining time, enable the button immediately
            resendButton.disabled = false;
        }
    </script>

@endsection
