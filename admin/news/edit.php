<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'news') {
    header("Location: ../index.php?pageAd=news&crud=index");
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = new news();
    $tieuDe=$moTa=$noiDung=$hinhAnh=$tacGia="";
    $row = $news->getNewsById($id);
    $tieuDe =  $row['tieuDe'];
    $moTa =$row['moTa'];
    $noiDung = $row['noiDung'];
    $hinhAnh =$row['hinhAnh'];
    $tacGia = $row['tacGia'];
    if (isset($_POST['chinhsua'])) {
        if (!empty($_POST['tieuDe'])) {
            $tieuDe = test_input($_POST['tieuDe']);
        }
        if (!empty($_POST['moTa'])) {
            $moTa = test_input($_POST['moTa']);
        }
        if (!empty($_POST['noiDung'])) {
            $noiDung = test_input($_POST['noiDung']);
        }
        if (!empty($_POST['tacGia'])) {
            $tacGia= test_input($_POST['tacGia']);
        }
        if (!empty($_FILES['hinhAnh']['name'])) {
            $timestamp = date('Ymd_His');
            $hinhAnh =$timestamp."_".$_FILES['hinhAnh']['name'];
        }
        $result = $news->updateNews($id, $tieuDe, $moTa, $noiDung, $hinhAnh, $tacGia);
        $checkUpload = true;
        if (!empty($_FILES['hinhAnh']['name'])) {
            if ( !uploadImage($hinhAnh, $row['hinhAnh'], $_FILES['hinhAnh']['tmp_name'])) 
            {
                $checkUpload=false;
                echo("upload file không thành công");
            }
        }
        if ($checkUpload === true) {
            header("location: index.php?pageAd=news&crud=index&msg=edit_news");
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
function uploadImage($anhMoi, $anhCu, $fileTam)
{
    $target_dir = "../public/images/news/";
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
            <label for="">Tiêu đề:</label>
            <input type="text" name="tieuDe" value="<?php echo ($row['tieuDe']) ?>">
        </div>
        <div class="form-group">
            <label for="">Mô tả:</label>
            <textarea name="moTa" rows="5" cols="40"><?php echo ($row['moTa']) ?></textarea>
        </div>
        <div class="form-group">
            <Label>Hinh ảnh:</Label>
            <input type="file" name="hinhAnh" class="anh">
        </div>
        <div class="form-group">
            <img class="hinh-anh" src="../public/images/news/<?php echo ($row['hinhAnh']); ?>" alt="Hình ảnh 1" title="Hình ảnh 1" width="100px" height="100px" style="margin:10px 10px 10px 200px; border-radius: 10px;">
        </div>
        <div class="form-group">
            <Label>Nội dung:</Label>
            <textarea name="noiDung" rows="5" cols="40"><?php echo ($row['noiDung']) ?></textarea>
        </div>
        <div class="form-group">
            <Label>Tác giả:</Label>
            <input type="text" name="tacGia" value="<?php echo ($row['tacGia']) ?>">
        </div>
        <div class="message-tin-tuc" style="color: red; margin-bottom: 10px;"></div>
        <div class="button-group">
            <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=news&crud=index'">Quay về</button>
            <input class="cap-nhat-sql" type="submit" value="Sửa" name="chinhsua">
        </div>
    </form>
</div>