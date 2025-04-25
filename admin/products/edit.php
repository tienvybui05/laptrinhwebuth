<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'product') {
    header("Location: ../index.php?pageAd=product&crud=index");
    exit();
}
include_once __DIR__ . '/../auth/checkLogin.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
    $listImage = explode(',', $row['hinhAnh']);
    $anh1 = $listImage[1];
    $anh2 = $listImage[2];
    $anh3 = $listImage[3];
    if (isset($_POST['chinhsua'])) {
        if (!empty($_POST['tensanpham'])) {
            $tenSanPham = test_input($_POST['tensanpham']);
        }
        if (!empty($_POST['thuonghieu'])) {
            $thuongHieu = test_input($_POST['thuonghieu']);
        }
        if (!empty($_POST['khuyenmai'])) {
            $khuyenMai = test_input($_POST['khuyenmai']);
        }
        if (!empty($_POST['gia'])) {
            $gia = test_input($_POST['gia']);
        }
        if (!empty($_POST['mota'])) {
            $moTa = test_input($_POST['mota']);
        }
        if (!empty($_POST['trongluong'])) {
            $trongLuong = test_input($_POST['trongluong']);
        }
        if (!empty($_POST['tonkho'])) {
            $tonKho = test_input($_POST['tonkho']);
        }
        if (!empty($_POST['docung'])) {
            $doCung = test_input($_POST['docung']);
        }
        if (!empty($_POST['diemcanbang'])) {
            $diemCanBang = test_input($_POST['diemcanbang']);
        }
        if (!empty($_POST['trinhdo'])) {
            $trinhDo = test_input($_POST['trinhdo']);
        }
        if (!empty($_FILES['anh1']['name'])) {
            $anh1 = $_FILES['anh1']['name'];
        }
        if (!empty($_FILES['anh2']['name'])) {
            $anh2 = $_FILES['anh2']['name'];
        }
        if (!empty($_FILES['anh3']['name'])) {
            $anh3 = $_FILES['anh3']['name'];
        }
        $anh = $listImage[0] . "," . $anh1 . "," . $anh2 . "," . $anh3;
        //Thuc thi truy van update
        $result = $product->updateProduct($id, $tenSanPham, $thuongHieu, $khuyenMai, $gia, $moTa, $trongLuong, $tonKho, $doCung, $diemCanBang, $anh, $trinhDo);
        // update hinh anh
        $checkUpload = true;

        if (!empty($_FILES['anh1']['name'])) {
            if (!uploadImage($anh1, $listImage[1], $_FILES['anh1']['tmp_name'], $listImage[0])) {
                $checkUpload = false;
            }
        }

        if (!empty($_FILES['anh2']['name'])) {
            if (!uploadImage($anh2, $listImage[2], $_FILES['anh2']['tmp_name'], $listImage[0])) {
                $checkUpload = false;
            }
        }

        if (!empty($_FILES['anh3']['name'])) {
            if (!uploadImage($anh3, $listImage[3], $_FILES['anh3']['tmp_name'], $listImage[0])) {
                $checkUpload = false;
            }
        }

        if ($checkUpload === true) {
            header("location: index.php?pageAd=product&crud=index&msg=edit_product");
            exit;
        } else {
            die("Upload không thành công!");
        }
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function uploadImage($anhMoi, $anhCu, $fileTam, $duongDanFile)
{
    $target_dir = "../public/images/product/" . $duongDanFile . "/";
    $target_file = $target_dir . basename($anhMoi);
    $target_file_old = $target_dir . basename($anhCu);
    if (move_uploaded_file($fileTam, $target_file)) {
        if (file_exists($target_file_old)) {
            unlink($target_file_old);
        }
        return true;
    }
    return false;
}


?>

<div>
    <h2>Chỉnh sửa thông tin sản phẩm</h2>
</div>
<div class="form-tao">
    <form action="" method="post" enctype="multipart/form-data" class="form-edit-product">
        <div class="form-group">
            <label for="">Tên sản phẩm:</label>
            <input type="text" name="tensanpham" value="<?php echo ($row['tenSanPham']) ?>">
        </div>
        <div class="form-group">
            <label for="">Thương hiệu:</label>
            <input type="text" name="thuonghieu" value="<?php echo ($row['thuongHieu']) ?>">
        </div>
        <div class="form-group">
            <Label>Ảnh 1:</Label>
            <input type="file" name="anh1" class="anh">
        </div>
        <div class="form-group">
            <Label>Ảnh 2:</Label>
            <input type="file" name="anh2" class="anh">
        </div>
        <div class="form-group">
            <Label>Ảnh 3:</Label>
            <input type="file" name="anh3" class="anh">
        </div>
        <div class="form-group">
            <img class="hinh-anh" src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[1]); ?>" alt="Hình ảnh 1" title="Hình ảnh 1" width="100px" height="100px" style="margin:10px 10px 10px 60px; border-radius: 10px;">
            <img class="hinh-anh" src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[2]); ?>" alt="Hình ảnh 2" title="Hình ảnh 2" width="100px" height="100px" style="margin:10px 10px 10px 10px; border-radius: 10px;">
            <img class="hinh-anh" src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[3]); ?>" alt="Hình ảnh 3" title="Hình ảnh 3" width="100px" height="100px" style="margin:10px 10px 10px 10px; border-radius: 10px;">
        </div>
        <div class="form-group">
            <Label>Khuyến mãi:</Label>
            <input type="text" name="khuyenmai" value="<?php echo ($row['khuyenMai']) ?>">
        </div>
        <div class="form-group">
            <Label>Giá:</Label>
            <input type="number" name="gia" value="<?php echo ($row['gia']) ?>" min="0" step="1">
        </div>
        <div class="form-group">
            <Label>Mô tả:</Label>
            <textarea name="mota" rows="5" cols="40"><?php echo ($row['moTa']) ?></textarea>
        </div>
        <div class="form-group">
            <Label>Trọng lượng:</Label>
            <input type="number" name="trongluong" value="<?php echo ($row['trongLuong']) ?>" min="0" step="1">
        </div>
        <div class="form-group">
            <Label>Tồn kho:</Label>
            <input type="number" name="tonkho" value="<?php echo ($row['tonKho']) ?>" min="0" step="1">
        </div>
        <div class="form-group">
            <Label>Độ cứng:</Label>
            <input type="text" name="docung" value="<?php echo ($row['doCung']) ?>">
        </div>
        <div class="form-group">
            <Label>Điểm cân bằng:</Label>
            <input type="text" name="diemcanbang" value="<?php echo ($row['diemCanBang']) ?>">
        </div>
        <div class="form-group">
            <Label>Trình độ:</Label>
            <input type="text" name="trinhdo" value="<?php echo ($row['trinhDo']) ?>">
        </div>
        <div class="message-product" style="color: red; margin-bottom: 10px;"></div>
        <div class="button-group">
            <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=product&crud=index'">Quay về</button>
            <input class="cap-nhat-sql" type="submit" value="Sửa" name="chinhsua">
        </div>
    </form>
</div>