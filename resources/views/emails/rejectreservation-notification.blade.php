<!DOCTYPE html>
<html>
<head>
    <title>Appointment Rejection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #e74c3c;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            line-height: 1.6;
            font-size: 16px;
        }
        .email-details {
            margin: 20px 0;
            padding: 15px;
            background: #f7f7f7;
            border: 1px solid #eee;
            border-radius: 8px;
        }
        .email-details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .email-details li {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .email-details li strong {
            color: #333;
        }
        .email-footer {
            text-align: center;
            padding: 15px;
            background: #e74c3c;
            color: #fff;
            font-size: 14px;
        }
        .email-footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Your Appointment Has Been Rejected</h1>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ $reservation->first_name }} {{ $reservation->last_name }}</strong>,</p>
            <p>We regret to inform you that your appointment has been rejected. Below are the details of your appointment:</p>
            <div class="email-details">
                <ul>
                    <li><strong>Date:</strong> {{ $reservation->appointment_date }}</li>
                    <li><strong>Time:</strong> {{ $reservation->appointment_time }}</li>
                    <li><strong>Remarks:</strong> {{ $reservation->remarks ?? 'N/A' }}</li>
                </ul>
            </div>
            <p>If you have any questions, please feel free to contact us.</p>
        </div>
        <div class="email-footer">
            <p>If you have any questions, feel free to <a href="mailto:hollywoodspectaclesoptical@gmail.com">contact us</a>.</p>
            <p>&copy; {{ date('Y') }} Hollywood Spectacles Optical. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
