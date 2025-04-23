
<?php
include_once __DIR__ . '/../auth/checkLogin.php';
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $user = new user();
    $result = $user->deleteUser($id);
    header("location: index.php?pageAd=user&crud=index&msg=delete_user");
    exit;
}
?>