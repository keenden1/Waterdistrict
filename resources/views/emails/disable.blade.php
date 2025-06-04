@extends('layout.layoutuser')
@section('title', 'Account Disabled')
@section('header_title', "Account Disabled")
@section('content')

    <div class="container">
        <div class="verification-card">
            <h2>Account Disabled</h2>

            <p class="info-text">
                Your account has been disabled by the administrator.
                If you believe this is a mistake or require further assistance, please contact support.
            </p>

            <p class="info-text timer-info">
                You may try again later or reach out to: 
                <span class="style">marbenasante.vwd@gmail.com</span>
            </p>

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
            max-width: 450px;
            text-align: center;
        }

        /* Header */
        .verification-card h2 {
            font-size: 1.8rem;
            color: #b00020;
            margin-bottom: 20px;
        }

        /* Info text */
        .info-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        /* Contact info / timer-info reuse */
        .timer-info {
            font-size: 1rem;
            color: #007bff;
        }

          .timer-info span{
            font-size: 1rem;
            color: #007bff;
            text-decoration: underline;
            font-weight: bold;
        }

        /* Button */
        .request-link-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .request-link-btn:hover {
            background-color: #0056b3;
        }
    </style>

@endsection
