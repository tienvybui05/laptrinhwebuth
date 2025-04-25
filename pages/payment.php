<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .main-payment {
            width: auto;
            min-height: calc(100vh - 120px);
            display: flex;
        }
        .main-leftpayment{
            width: 50%;
            padding: 30px 30px 30px 150px;
            background-color: #F4F4F4;
        }
        .leftpayment h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .signup-link {
            margin: 10px 0 20px;
            font-size: 14px;
        }

        .signup-link a {
            color: #e74c3c;
            text-decoration: none;
        }

        .slidebarpayment{
            width: 40%;
            padding: 20px;
            background-color: #ececec;
            border-left: 1px solid #ddd;
            padding-right: 10%;
            padding-left: 40px;
        }
        .row{
            box-sizing: border-box;
        }
        /* Định dạng input và textarea */
        .row input,
        .row textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: white;
        }

        .row input:focus,
        .row textarea:focus {
            border-color: #050505;
            outline: none;
        }

        #hang1{
            display: flex;
            justify-content: space-between;
        }
        #formhoten{
            margin-right: 0px;
            width: 65%;
        }
        #formsdt{
            width: 32%;
        }



        /* phuong thuc thanh toan */
        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: white;
            
        }
        .payment-status{
            padding: 20px;
            border: 1px solid #e0e0e0;
        }
        .option-content{
            color: #555;
            background-color: #F4F4F4;
            padding: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        .method-option label {
            display: block;
            cursor: pointer;
        }






        /* Phần sản phẩm trong đơn hàng */
        .payment-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        /* Phần tổng tiền */
        .totalpayment-item {
            margin: 20px 0;
        }
        .totalpayment-item h3 {
            color: #e74c3c;
            font-size: 1.2rem;
        }

        /* Nút thanh toán */
        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }



        .slidebarpayment h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        

        

        
        .form-sale{
            width: 80%;
            padding: 15px;
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }
        .coupon-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .apply-coupon {
            color: #e74c3c;
            font-weight: 500;
            font-size: 14px;
        }

        .price-summary {
            margin: 25px 0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 15px;
            color: #555;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            font-size: 16px;
        }

        .total-amount {
            color: #e74c3c;
            font-size: 18px;
        }

        .checkout-btn {
            width: 100%;
            padding: 14px;
            background: #000000;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #242424;
            color: rgb(255, 255, 255);
        }

        /* Header đơn hàng lllllllllllll*/
        .product-name {
            font-size: 15px;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.4;
        }



        .product-price {
            font-weight: 500;
            color: #333;
            width: 100px;
            text-align: right;
        }

        .order-header {
            display: flex;
            padding: 10px 0;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .header-product {
            flex: 2;
            padding-right: 15px;
        }

        .header-qty {
            width: 80px;
            text-align: center;
        }

        .header-price {
            width: 100px;
            text-align: right;
        }

        /* Điều chỉnh lại product-summary */
        .product-summary {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
        }

        .product-info {
            flex: 2;
            padding-right: 15px;
        }

        .product-qty {
            width: 80px;
            text-align: center;
            color: #666;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <!--Thanh menu  -->
                <nav class="navbar">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <ul id="main-menu">
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                    <!--Thanh tìm kiếm  -->
                    <div class="search-bar">
                        <input type="text" placeholder="Tìm kiếm..." />
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="right-icons">
                        <a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
                        <a href="#" class="user-icon"><i class="fas fa-user"></i></a>
                    </div>
                </nav>
            </div>
        </header>
        <main class="main-payment">
            <div class="main-leftpayment">
                <div class="leftpayment">
                    <h1>Thông tin giao hàng</h1>
                    <div class="signup-link">
                        Bạn đã có tài khoản? <a href="./register.html">Đăng ký</a>
                    </div>
                    <hr>
                    <form>
                        <div class="row">
                            <div id="hang1">
                                <div id="formhoten">
                                    <input placeholder="Họ và tên" type="text" class="form-control" name="ten" required>
                                </div>
                                <div id="formsdt">
                                    <input placeholder="Điện thoại" type="tel" class="form-control" name="dienthoai" required>
                                </div>
                            </div>
                            <div class="form2">
                                <input placeholder="Email" type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form2">
                                <input placeholder="Địa chỉ" type="text" class="form-control" name="diachi" required>
                            </div>
                            <div class="form2">
                                <textarea placeholder="Ghi chú" class="form-control" name="noidung" rows="5" required></textarea>
                            </div>
                        </div>
                    </form>
                    <h3>Phương thức thanh toán</h3>
                    <div class="payment-method">                 
                        <div class="method-option">
                            <label>
                                <div class="payment-status">
                                    <input type="radio" name="payment" value="cod" checked>
                                    <strong>Thanh toán khi giao hàng (COD)</strong>
                                </div>
                                <div class="option-content">                               
                                        Tất cả đơn hàng được kiểm tra trước khi thanh toán<br>
                                        • Thời gian nhận hàng nội thành Hà Nội: 1h-24h<br>
                                        • Ngoại thành & tỉnh khác: 2-3 ngày<br>
                                        <em>Nếu không hài lòng, chỉ trả phí vận chuyển 45,000đ</em>
                                </div>
                            </label>
                        </div>
                        
                        <div class="method-option">
                            <label>
                                <div class="payment-status">
                                    <input type="radio" name="payment" value="bank">
                                    <strong>Chuyển khoản ngân hàng</strong>
                                </div>
                                <div class="option-content">
                                    Liên hệ hotline trước khi chuyển khoản : 0971.415.565</br>
                                    Số Tài Khoản : 019704060152822</br>
                                    Ngân hàng Quốc Tế VIB</br>
                                    Chủ tài khoản : ĐÀO VĂN CÔNG</em>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slidebarpayment">
                <h2 style="text-align: center;">ĐƠN HÀNG CỦA BẠN</h2>
    
                <!-- Header bảng -->
                <div class="order-header">
                    <div class="header-product">Sản phẩm</div>
                    <div class="header-qty">Số lượng</div>
                    <div class="header-price">Tạm tính</div>
                </div>
                <hr>
                <div class="product-all">
                    <!-- Sản phẩm 1 -->
                    <div class="product-summary">
                        <div class="product-info">
                            <p class="product-name">Vợt yonex 100zz navy</p>
                        </div>
                        <div class="product-qty">x 2</div>
                        <div class="product-price">1,300,000₫</div>
                    </div>
                    
                    <!-- Sản phẩm 2 -->
                    <div class="product-summary">
                        <div class="product-info">
                            <p class="product-name">Vợt 2</p>
                        </div>
                        <div class="product-qty">x 1</div>
                        <div class="product-price">4,800,000₫</div>
                    </div>
                </div>
                <hr>
                <div class="coupon-section">
                    <div class="coupon-header">
                        <input placeholder="Mã giảm giá" type="text" class="form-sale" name="sale">
                        <a href="#" class="apply-coupon">Sử dụng</a>
                    </div>
                </div>
                <hr>
                <div class="price-summary">
                    <div class="price-row">
                        <span>Tạm tính</span>
                        <span>5,721,927₫</span>
                    </div>
                    <div class="price-row">
                        <span>Phí vận chuyển</span>
                        <span>35,000₫</span>
                    </div>
                    <hr>
                    <div class="total-row">
                        <strong>Tổng cộng</strong>
                        <strong class="total-amount">5,756,927₫</strong>
                    </div>
                </div>
                
                <button class="checkout-btn">Đặt hàng</button>

            </div>
        </main>
        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3>Thông tin liên hệ</h3>
                    <p>Địa chỉ: 123 đường ABC, TP.HCM</p>
                    <p>Email:
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h3>Theo dõi chúng tôi</h3>
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i>Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i>Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i>Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i>Linkedin</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <script src="../public/js/payment.js"></script>

</body>

</html>