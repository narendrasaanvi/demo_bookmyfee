<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #fff;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            margin: 20px 0;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
         <img src="{{URL('/assets/images/logo.png')}}" style="width:140px">
        </div>
        <div class="content">
        <h2>Hello, {{ $user->name }}!</h2>
            <p>Thank you for signing up for our service. We’re excited to have you on board.</p>
            <p>Please confirm your email address by clicking the button below:</p>
            <p><a href="{{URL('login')}}" style="display: inline-block; background-color: #FF6A00; color: #ffffff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Confirm Email</a></p>
            <p>Username:{{ $user->email }}</p>
            <p>Username:{{ $user->sendpassword }}</p>
            <p>If you have any questions, feel free to reach out to us.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
