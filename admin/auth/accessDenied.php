<?php http_response_code(403); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/themify-icons/themify-icons.css">
    <title>403</title>
    <style>
        .access-denied{
            padding: 20px;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .access-denied div{
            display: flex;
            padding: 10px;
        }
        .access-denied div i{
            font-size: 20px;
            color: red;
            padding: 10px;
        }
        .access-denied div span{
            font-size: 100px;
            color:rgb(143, 244, 230);
            padding: 10px;
        }
        .access-denied .noi-dung-canh-bao{
            font-size: 20px;
            color:rgb(68, 244, 220);
        }
        .access-denied a{
            margin-top:20px;
            padding: 10px;
            border-radius: 10px;
            background-color: rgb(143, 244, 230);
            text-decoration:none ;
            color:rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    <div class="access-denied">
        <div>
            <i class="ti-na"></i>
            <span>403</span>
        </div>
        <span class="noi-dung-canh-bao">Bạn không có quyền truy cập</span>
        <a href="../../public/index.php">Quay về trang chủ</a>
    </div>
</body>
</html>