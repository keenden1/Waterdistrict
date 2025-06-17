<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Update</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            padding: 40px;
        }
        .footer {
            background-color: #333333;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .status {
            font-weight: bold;
            color: #345C72;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <p>Hello {{ $name }},</p>

        @if($status == 'approved')
            <p>Your leave application has been <span class="status">recommended for Approval</span>.</p>
        @elseif($status == 'declined')
            <p>Your leave application has been <span class="status">recommended for Disapproval</span>.</p>
            <p><strong>Reason:</strong> {{ $reason }}</p>
        @elseif($status == 'account_activated')
            <p>Your account has been <span class="status">Activated</span>.</p>
        @elseif($status == 'account_disabled')
            <p>Your account has been <span class="status">Aisabled</span>.</p>
        @endif

        <p>Thank you,<br>Villasis Water District</p>
    </div>

    <div class="footer">
        &copy; {{ now()->year }} Villasis Water District
    </div>
</body>
</html>
