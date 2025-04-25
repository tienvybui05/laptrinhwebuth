
<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'user') {
    header("Location: ../index.php?pageAd=user&crud=index");
    exit();
}
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $user = new user();
    $result = $user->deleteUser($id);
    header("location: index.php?pageAd=user&crud=index&msg=delete_user");
    exit;
}
?>