<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'news') {
    header("Location: ../index.php?pageAd=newst&crud=create");
    exit();
}
$news = new news();
// Tạo các biến
$tieuDe=$moTa=$noiDung=$hinhAnh=$tacGia="";
if (isset($_POST['taomoi'])) 
{
    $tieuDe = test_input($_POST['tieuDe']);
    $moTa = test_input($_POST['moTa']);
    $noiDung = test_input($_POST['noiDung']);
    $tacGia = test_input($_POST['tacGia']);
    $hinhAnh = $_FILES['hinhAnh']['name'];
    $timestamp = date('Ymd_His');
    $hinhAnh =$timestamp."_".$_FILES['hinhAnh']['name'];
    $upload_dir = '../public/images/news/';
    if(file_exists($upload_dir))
    {
        if(upLoadImage( $hinhAnh, $_FILES["hinhAnh"]["tmp_name"]))
        {
            $result = $news->addNew($tieuDe,$moTa,$hinhAnh,$noiDung,$tacGia);
            if($result)
            {
                header("location: index.php?pageAd=news&crud=index&msg=create_news");
                exit;
            }
            else
            {
                echo("Thêm tin tức vào database không thành công");
            }
        }
        else
        {
            echo("upload file không thành công");
        }
    }
    else
    {
        echo("Không tìm thấy folder");
    }

    
}
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function upLoadImage($x, $y)
{
    $target_dir_img = '../public/images/news/';
    $target_file_img = $target_dir_img . basename($x);
    if (move_uploaded_file($y, $target_file_img)) {
        return true;
    }
    return false;
}
?>
<div>
    <h2>Thêm tin tức</h2>
</div>
<div class="form-tao">
    <form action="" method="post" enctype="multipart/form-data" class="form-create-tin-tuc">
        <div class="form-group">
            <label for="">Tiêu đề:</label>
            <input type="text" name="tieuDe">
        </div>
        <div class="form-group">
            <label for="">Mô tả:</label>
            <textarea name="moTa" rows="5" cols="40"></textarea>
        </div>
        <div class="form-group">
            <Label>Hình ảnh:</Label>
            <input type="file" name="hinhAnh" class="anh">
        </div>
        <div class="form-group">
            <label for="">Nội dung:</label>
            <textarea name="noiDung" rows="5" cols="40"></textarea>
        </div>
        <div class="form-group">
            <Label>Tác giả:</Label>
            <input type="text" name="tacGia">
        </div>
        <div class="message-tin-tuc" style="color: red; margin-bottom: 10px;"></div>
        <div class="button-group">
            <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=news&crud=index'">Quay về</button>
            <input class="cap-nhat-sql" type="submit" value="Tạo mới" name="taomoi">
        </div>
    </form>
</div>