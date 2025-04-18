<?php 
include '../auth/checkLogin.php';
include '../entities/product.php';
$product = new product();
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$thuongHieu = isset($_GET['sort']) ? $_GET['sort'] : 'tatca';
$result = $product->filterProductManager($thuongHieu,$keyword);
?>
<?php if(isset($_GET['msg'])&& $_GET['msg']=='create_product'): ?>
<div class="toast-alert">✅ Thêm sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'edit_product'): ?>
<div class="toast-alert">✅ Chỉnh sửa sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'delete_product'): ?>
<div class="toast-alert">✅ Xóa sản phẩm thành công!</div>
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
                <h2>Danh sách sản phẩm</h2>
                <div class="search-and-create">
                   
                    <div class="tim-kiem">
                        <form action="" method="get">
                            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text" 
                            value ="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <button type="submit"><p>Tìm kiếm</p></button>
                        </form>
                        <select name="thuonghieu" class="loc-thuong-hieu-product" onchange="applySort(this.value)">
                            <option value="tatca" <?php if(isset($thuongHieu) && $thuongHieu=="tatca"){  echo "selected"; } ?>>Tất cả</option>
                            <option value="Victor" <?php if(isset($thuongHieu) && $thuongHieu=="Victor"){ echo "selected";} ?>>Victor</option>
                            <option value="Yonex" <?php if(isset($thuongHieu) && $thuongHieu=="Yonex") { echo "selected";} ?>>Yonex</option>
                            <option value="Lining" <?php if(isset($thuongHieu) && $thuongHieu=="Lining"){ echo "selected";} ?> >Lining</option>
                        </select>
                    </div>
                    <div class="tao-moi">
                    
                        <a href="create.php">Tạo mới</a>
                    </div>
                </div>
                <div class="danh-sach">
                    <table class="table-danh-sach">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Thương hiệu</th>
                            <th>Hình ảnh</th>
                            <th>Khuyến mãi</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trình độ</th>
                            <th>Hành động</th>
                        </tr>
                        <?php
                                while($row=$product->getProductFetch())
                                {
                                    $listImage =explode(',',$row['hinhAnh']);

                                    ?><tr>
                                        <td><?php echo($row['tenSanPham']); ?></td>
                                        <td><?php echo($row['thuongHieu']); ?></td>
                                        <td class="hinh-anh"><img src="../../public/images/product/<?php echo ($listImage[0]."/".$listImage[1]);?>" alt=""></td>
                                        <td><?php echo($row['khuyenMai']); ?></td>
                                        <td><?php echo($row['gia']); ?></td>
                                        <td><?php echo($row['tonKho']); ?></td>
                                        <td><?php echo($row['trinhDo']); ?></td>
                                        <td class ="hanh-dong">
                                            <a class="sua sua-product" href="edit.php?id=<?php echo($row['idProduct']); ?>">Sửa</a>
                                            <a class="chitiet chitiet-product" href="detail.php?id=<?php echo($row['idProduct']); ?>">Chi tiết</a>
                                            <a class="xoa xoa-product" href="#" data-url="delete.php?id=<?php echo($row['idProduct']); ?>">Xóa</a>

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