<?php
include '../entities/user.php';
$user = new user();
$keyword = isset($_GET['keyword']) ? $_GET['keyword']:'';
$result = $user->getUser($keyword);


?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'delete_user'): ?>
    <div class="toast-alert">✅ Xóa tài khoản thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'create_user'): ?>
    <div class="toast-alert">✅ Thêm tài khoản thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'edit_user'): ?>
    <div class="toast-alert">✅ Chỉnh sửa tài khoản thành công!</div>
<?php endif; ?>

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
                <h2>Danh sách tài khoản</h2>
                <div class="search-and-create">
                   
                    <div class="tim-kiem">
                        <form action="" method="get">
                            <input name="keyword" placeholder="Nhập họ tên" type="text" 
                            value ="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <button type="submit"><p>Tìm kiếm</p></button>
                        </form>
                    </div>
                    <div class="tao-moi">
                        <a href="create.php">Tạo mới</a>
                    </div>
                </div>
                <div class="danh-sach">
                    <table class="table-danh-sach">
                        <tr>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                        <?php 
                        while($row = $user->getUserFetch() )
                        { ?>
                             <tr>
                                <td><?php echo($row['hoTen']); ?></td>
                                <td><?php echo($row['soDienThoai']); ?></td>
                                <td><?php echo($row['username']); ?></td>
                                <td><?php echo($row['password']); ?></td>
                                <td><?php echo($row['diaChi']); ?></td>
                                <td><?php echo($row['vaiTro']); ?></td>
                                <td class ="hanh-dong">              
                                <a class="sua sua-product" href="edit.php?id=<?php echo($row['idUser']);?>">Sửa</a>
                                <a class="xoa xoa-product" href="#" data-url="delete.php?id=<?php echo($row['idUser']); ?>">Xóa</a>      
                                <div class="xoa-confirmModal modal">
                                    <div class="xoa-modal-content">
                                        <p>Bạn có chắc chắn muốn xóa không?</p>
                                        <div class="xoa-buttons">
                                        <button class="xoa-cancelBtn">Hủy</button>
                                        <button class="xoa-confirmBtn">Xóa</button>
                                        </div>
                                    </div>
                                </div>       
                                </td>
                            </tr>
                        <?php }
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