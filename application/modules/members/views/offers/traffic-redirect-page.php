<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 550px;
            animation: fadeIn 0.6s ease-in-out;
        }
        
        .header {
            background-color: #4a6fa5;
            color: white;
            padding: 25px 30px;
            position: relative;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 15px;
            opacity: 0.9;
        }
        
        .icon {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 28px;
        }
        
        .content {
            padding: 30px;
        }
        
        .message {
            background-color: #f8fafd;
            border-left: 4px solid #4a6fa5;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 4px;
            font-size: 15px;
            line-height: 1.6;
            color: #333;
        }
        
        .sources {
            background-color: #f5f5f5;
            padding: 15px 20px;
            border-radius: 6px;
        }
        
        .sources p {
            font-weight: 600;
            margin-bottom: 10px;
            color: #444;
        }
        
        .sources ul {
            list-style-type: none;
        }
        
        .sources li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .sources a {
            color: #4a6fa5;
            text-decoration: none;
            transition: color 0.2s;
            margin-left: 10px;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sources a:hover {
            color: #2c4b7a;
            text-decoration: underline;
        }
        
        .source-icon {
            color: #4a6fa5;
            margin-right: 5px;
            font-size: 16px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 550px) {
            .header {
                padding: 20px;
            }
            
            .icon {
                top: 20px;
                right: 20px;
            }
            
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Access Denied</h1>
            <p>Invalid traffic source</p>
            <div class="icon">⚠️</div>
        </div>
        <div class="content">
            <div class="message">
                Sorry, your traffic must come from the website provided below. 
                Please use one of the allowed sources to access this page.
            </div>
            
            <div class="sources">
                <p>Allowed sources:</p>
                <ul>
                    <?php
                    // Xử lý chuỗi URL ngăn cách bởi dấu phẩy
                    $url_array = explode(',', $trafficurl);
                    
                    // Hiển thị từng URL được phép
                    foreach ($url_array as $url) {
                        $url = trim($url); // Loại bỏ khoảng trắng thừa
                        echo '<li>
                            <span class="source-icon">🔗</span>
                            <a href="' . $url . '" target="_blank">' . $url . '</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>