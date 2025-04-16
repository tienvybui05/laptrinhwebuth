<?php 
include '../auth/checkLogin.php';
include_once '../entities/orders.php';
$orders= new orders();
$keyword = isset($_GET['keyword']) ? $_GET['keyword']:''; 
$result = $orders->getOrders($keyword);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../../public/themify-icons/themify-icons.css">
</head>
<body>
    <div id="admin-container">
        <div id="sidebar">
            <div id="logo" >
                <a href="#">
                  <img src="../../public/images/logo.png" alt="">  
                </a>
            </div>
            <div id="sidebar-menu">
                <ul class="de-muc">
                    <li class="muc">
                        <i class="nav-arrow-down ti-user"></i>
                        <a href="#"> Tải khoản</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-briefcase"></i>
                        <a href="#"> Sản phẩm</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-shopping-cart"></i>
                        <a href="#"> Đơn hàng</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-comment"></i>
                        <a href="#"> Đánh giá</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-drupal"></i>
                        <a href="#"> Khách hàng</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="main-content">
            <div id="header">
               <div class="search-admin">
                    <i class="nav-arrow-down ti-search"></i>
                   <input class="tim-kiem" type="text" placeholder="Tìm kiếm..">
               </div>
               <div class="login-admin">
                    <div class="login">
                        <a href="#">Login</a>
                    </div>
               </div>
            </div>
            <div id="content">
                <h2>Quản lý giỏ hàng</h2>
                <div class="search-and-create">
                   
                    <div class="tim-kiem">
                        <form action="" method="get">
                            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text" 
                            value ="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <button type="submit"><p>Tìm kiếm</p></button>
                        </form>
                    </div>
                </div>
                <div class="danh-sach">
                    <table class="table-danh-sach">
                        <tr>
                            <th>Khách hàng</th>
                            <th>Người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Phương thức</th>
                            <th>Ngày đặt hàng</th>
                            <th>Thành tiền</th>
                            <th>Ghi chú</th>
                        </tr>
                        <?php
                                while($row = $orders->getOrdersFetch())
                                {
                                    ?><tr>
                                        <td><?php echo($row['hoTen']); ?></td>
                                        <td><?php echo($row['nguoiNhan']); ?></td>
                                        <td><?php echo($row['soDienThoai']); ?></td>
                                        <td><?php echo($row['diaChi']); ?></td>
                                        <td><?php echo($row['tenSanPham']); ?></td>
                                        <td><?php echo($row['soLuong']); ?></td>
                                        <td><?php echo($row['phuongThuc']); ?></td>
                                        <td><?php echo($row['ngayDatHang']); ?></td>
                                        <td><?php echo($row['thanhTien']); ?></td>
                                        <td><?php echo($row['ghiChu']); ?></td>
                                        </tr>
                                    <?php
                                }
                        ?>
                    </table>
                    
                </div>
                
            </div>
            <div id="footer">
                <p>Bản quyền thuộc <a href="https://github.com/tienvybui05/laptrinhwebuth" > Vợt cầu lông</a></p>
            </div>
        </div>
    </div>
<script src="../main.js"></script>
</body>
</html>