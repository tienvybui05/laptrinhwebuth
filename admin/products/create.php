<?php
include '../entities/product.php';
$product = new product();
// Tạo các biến
$tenSanPham = $thuongHieu = $anh = $khuyenMai = $gia = "";
$moTa=$trongLuong = $tonKho = $doCung = $diemCanBang = $trinhDo="";
$anh1 =$anh2=$anh3="";
if(isset($_POST['taomoi']))
{
    $tenSanPham = test_input($_POST['tensanpham']);
    $thuongHieu = test_input($_POST['thuonghieu']);
    $khuyenMai = test_input($_POST['khuyenmai']);
    $gia = test_input($_POST['gia']);
    $moTa = test_input($_POST['mota']);
    $tonKho = test_input($_POST['tonkho']);
    $doCung = test_input($_POST['docung']);
    $diemCanBang = test_input($_POST['diemcanbang']);
    $trinhDo = test_input($_POST['trinhdo']);
    $trongLuong = test_input($_POST['trongluong']);
    //Tạo đường dẫn 
    $product_name = $tenSanPham; 
    $timestamp = date('Ymd_His');
    $folder_name = $product_name . '_' . $timestamp;
    $upload_dir = '../../public/images/product/' . $folder_name . '/';
    $anh = $folder_name.",".$_FILES['anh1']['name'].",".$_FILES['anh2']['name'].",".$_FILES['anh3']['name'];
    //add vào csdl
    $result = $product->addProduct($tenSanPham,$thuongHieu, $khuyenMai,$gia,$moTa,$trongLuong,$tonKho,$doCung,$diemCanBang,$anh,$trinhDo);
    //upload file hình ảnh 
    if (!file_exists($upload_dir)) 
    {
        mkdir($upload_dir, 0777, true);
        if ( upLoadImage($_FILES["anh1"]["name"],$_FILES["anh1"]["tmp_name"],$folder_name) === true &&
             upLoadImage($_FILES["anh2"]["name"],$_FILES["anh2"]["tmp_name"],$folder_name) === true &&
             upLoadImage($_FILES["anh3"]["name"],$_FILES["anh3"]["tmp_name"],$folder_name) === true)
            {
                header("location: index.php");
                exit;
            }
        else
            {
                    echo "Có lỗi khi upload ảnh. Vui lòng kiểm tra lại.";
            }
    }
    else
    {
        echo "Folder ảnh đã tồn tại";
    }

    
}       
function test_input($data)
{
    $data =trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function upLoadImage($x,$y,$folder_name)
{
    $target_dir_img ="../../public/images/product/".$folder_name."/";
    $target_file_img=$target_dir_img.basename($x); 
    if(move_uploaded_file($y, $target_file_img))
    {
       return true;
    }
    return false;
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
                    <h2>Thêm sản phẩm</h2>
                </div>
                <div class="form-tao">
                    <form action="" method="post" enctype="multipart/form-data" class="form-create-product">
                        <div class="form-group">
                            <label for="">Tên sản phẩm:</label>
                            <input type="text" name="tensanpham">
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu:</label>
                            <input type="text" name="thuonghieu">
                        </div>
                        <div class="form-group">
                            <Label>Ảnh 1:</Label>
                            <input type="file" name ="anh1" class="anh">
                        </div>
                        <div class="form-group">
                            <Label>Ảnh 2:</Label>
                            <input type="file" name ="anh2" class="anh">
                        </div>
                        <div class="form-group">
                            <Label>Ảnh 3:</Label>
                            <input type="file" name ="anh3"class="anh">
                        </div>
                        <div class="form-group">
                            <label for="">Khuyến mãi:</label>
                            <input type="text" name="khuyenmai">
                        </div>
                        <div class="form-group">
                            <label for="">Giá:</label>
                            <input type="number" name="gia" min="0" step="1">
                        </div>
                        <div class="form-group">
                            <Label>Mô tả:</Label>
                            <textarea name="mota" rows="5" cols="40"></textarea>
                        </div>
                        <div class="form-group">
                            <Label>Trọng lượng:</Label>
                            <input type="number" name= "trongluong"  min="0" step="1">
                        </div>
                        <div class="form-group">
                            <Label>Tồn kho:</Label>
                            <input type="number" name= "tonkho" min="0" step="1">
                        </div>
                        <div class="form-group">
                            <Label>Độ cứng:</Label>
                            <input type="text" name= "docung">
                        </div>
                        <div class="form-group">
                            <Label>Điểm cân bằng:</Label>
                            <input type="text" name= "diemcanbang">
                        </div>
                        <div class="form-group">
                            <Label>Trình độ:</Label>
                            <input type="text" name= "trinhdo">
                        </div>
                        <div class="message-product" style="color: red; margin-bottom: 10px;"></div>
                        <div class="button-group">
                        <button class="quay-ve" type="button" onclick="window.location.href='index.php'">Quay về</button>
                            <input class="cap-nhat-sql"type="submit" value="Tạo mới" name="taomoi">
                        </div>
                    </form>
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