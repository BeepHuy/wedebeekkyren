<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: rgb(29, 64, 92);
            --primary-light: rgba(29, 64, 92, 0.1);
            --accent-color: rgb(45, 125, 179);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-light), #f8f9fa);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(29, 64, 92, 0.15);
            width: 100%;
            max-width: 520px;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .icon-container {
            margin: 0 auto 30px;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .success-circle {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            background-color: var(--primary-color);
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 25px rgba(29, 64, 92, 0.25);
            animation: pulse 2s infinite;
        }
        
        .checkmark {
            color: white;
            font-size: 60px;
            animation: fadeIn 1s ease-out;
        }
        
        .success-title {
            color: var(--primary-color);
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }
        
        .message {
            color: #555;
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 35px;
            padding: 0 15px;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-container">
            <div class="success-circle">
                <i class="fa-solid fa-check checkmark"></i>
            </div>
        </div>
        
        <h1 class="success-title">Success</h1>
        
        <p class="message">
            Your email has been successfully verified. Please note that 
            you will receive a confirmation once your application has 
            been reviewed.
        </p>
    </div>
</body>
</html>