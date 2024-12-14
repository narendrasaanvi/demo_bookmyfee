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
        <h1>New Tournament Details</h1>
        <p>Hello,</p>
        <p>We have a new tournament for you!</p>
        <ul>
            <li><strong>Name:</strong> {{ $tournament->title }}</li>
            <li><strong>Organizer:</strong> {{ $tournament->organizer }}</li>
            <li><strong>Start Date:</strong> {{ $tournament->start_date }}</li>
        </ul>
        <p>Don't miss it!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Bookmyfee. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
