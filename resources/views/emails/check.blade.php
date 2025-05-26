@extends('layout.layoutuser')
@section('title', 'Account Status')
@section('header_title', "CHECK STATUS")
@section('content')

    <div class="container">
        <div class="verification-card">
            <h2>Pending Admin Approval</h2>

            <p class="info-text">Your account is awaiting admin approval and will be verified soon. We appreciate your patience and look forward to having you onboard!</p>

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


@endsection
