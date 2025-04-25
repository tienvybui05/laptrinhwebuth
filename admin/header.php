<?php 
if (!defined('ALLOW_INCLUDE')) {
    header("location: auth/accessDenied.php");
}
?>
<div id="header">
    <div class="datetime-glass-header">
        <i class="ti-alarm-clock"></i>
        <div id="datetime" class="datetime-glass"></div>
    </div>
    <div class="login-admin">
        <p><?php echo ($hoTenAdmin); ?></p>
        <div class="login">
            <a href="auth/logout.php"><i class="ti-power-off"></i></a>
        </div>
    </div>
</div>