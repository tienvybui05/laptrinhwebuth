<?php

include '../entities/product.php';
if(isset($_GET['id']))
{
    $id= test_input($_GET['id']);
    $product = new product();
    $row = $product->getProductbyId($id);
    $tenSanPham = $row['tenSanPham'];
    $thuongHieu = $row['thuongHieu'];
    $khuyenMai = $row['khuyenMai'];
    $gia = $row['gia'];
    $moTa = $row['moTa'];
    $tonKho = $row['tonKho'];
    $doCung = $row['doCung'];
    $diemCanBang = $row['diemCanBang'];
    $trinhDo = $row['trinhDo'];
    $trongLuong = $row['trongLuong'];
    $anh = $row['hinhAnh'];
    $listImage = explode(',',$row['hinhAnh']);
    $anh1 = $listImage[1];
    $anh2 = $listImage[2];
    $anh3 = $listImage[3];
}
function test_input($data)
{
    $data =trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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
                
                <div>
                    <h2>Chi tiết thông tin sản phẩm</h2>
                </div>
                <div class="detail-product">
                    <div class ="ten-va-thuong-hieu">
                        <p>Tên sản phẩm: <span><?php echo($row['tenSanPham']); ?></span></p>
                        
                        <p>Thương hiệu: <span><?php echo($row['thuongHieu']); ?></span> </p>
                       
                    </div>
                    <div class="gia-va-khuyen-mai">
                        <p>Giá: <span><?php echo($row['gia']); ?></span></p>
                        <p>Khuyến mãi: <span><?php echo($row['khuyenMai']); ?></span> </p>
                    </div>
                    <div class="hinh-detail-product">
                        <div>
                            <p>Hình 1</p>
                            <img src="../../public/images/product/<?php echo ($listImage[0]."/".$listImage[1]);?>" alt="Hình 1">
                        </div>
                        <div>
                            <p>Hình 2</p>
                            <img src="../../public/images/product/<?php echo ($listImage[0]."/".$listImage[2]);?>" alt="Hình 2 ">
                        </div>
                        <div>
                            <p>Hình 3</p>
                            <img src="../../public/images/product/<?php echo ($listImage[0]."/".$listImage[3]);?>" alt="Hình 3">
                        </div>
                    </div>
                    <div class="mo-ta-san-pham">
                        <p>Mô tả sản phẩm:</p>
                        <p> <span><?php echo($row['moTa']); ?></span></p>
                    </div>
                    <div class="thong-so-ki-thuat">
                        <p>Thông số kĩ thuật:</p>
                        <ul>
                            <li>Trọng lượng: <span><?php echo($row['trongLuong']); ?></span> </li>
                            <li>Tồn kho:  <span><?php echo($row['tonKho']); ?></span> </li>
                            <li>Độ cứng: <span><?php echo($row['doCung']); ?></span> </li>
                            <li>Điểm cân bằng: <span><?php echo($row['diemCanBang']); ?></span></li>
                            <li>Trình độ: <span><?php echo($row['trinhDo']); ?></span></li>
                            
                        </ul>
                    </div>
                    <div class="detail-product-quay-ve">
                        <button class="quay-ve" type="button" onclick="window.location.href='index.php'">Quay về</button>
                    </div>
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