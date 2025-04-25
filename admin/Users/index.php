<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'user') {
    header("Location: ../index.php?pageAd=user&crud=index");
    exit();
}
$user = new user();
$soUser = 20;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$role = isset($_GET['sort']) ? $_GET['sort'] : 'tatca';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$result = $user->getPaginatedUserOfAdmin($currentPage, $soUser, $keyword, $role);

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

<h2>Danh sách tài khoản</h2>
<div class="search-and-create">
    <div class="tim-kiem">
        <form action="" method="get">
            <input name="keyword" placeholder="Nhập họ tên" type="text"
                value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($role); ?>">
            <input type="hidden" name="pageAd" value="user">
            <input type="hidden" name="crud" value="index">
            <button type="submit">
                <p>Tìm kiếm</p>
            </button>
        </form>
        <select name="sort" class="loc-role-user" onchange="applySort(this.value)">
            <option value="tatca" <?php if (isset($role) && $role == "tatca") {echo "selected";} ?>>Tất cả</option>
            <option value="customer" <?php if (isset($role) && $role == "customer") { echo "selected";} ?>>Customer</option>
            <option value="admin" <?php if (isset($role) && $role == "admin") { echo "selected";} ?>>Admin</option>
        </select>
    </div>
    <div class="tao-moi">
        <a href="index.php?pageAd=user&crud=create">Tạo mới</a>
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
        if (!empty($result[0])) {
            foreach ($result[0] as $row) { ?>
                <tr>
                    <td><?php echo ($row['hoTen']); ?></td>
                    <td><?php echo ($row['soDienThoai']); ?></td>
                    <td><?php echo ($row['username']); ?></td>
                    <td><?php echo ($row['password']); ?></td>
                    <td><?php echo ($row['diaChi']); ?></td>
                    <td><?php echo ($row['vaiTro']); ?></td>
                    <td class="hanh-dong">
                        <a class="sua sua-product" href="index.php?pageAd=user&crud=edit&id=<?php echo ($row['idUser']); ?>">Sửa</a>
                        <a class="xoa xoa-product" href="#" data-url="index.php?pageAd=user&crud=delete&id=<?php echo ($row['idUser']); ?>">Xóa</a>
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
        }
        ?>

    </table>

</div>
<div class="phan-trang">
    <?php
    for ($i = 1; $i <= $result[1]; $i++) {
        $link = "index.php?pageAd=user&crud=index&page=$i&keyword=" . urlencode($keyword) . "&sort=" . urlencode($role);
        if ($currentPage == $i) 
        {
            echo "<span class='now'>$i</span> ";
        } else 
        {
            echo "<a href='$link'>$i</a> ";
        }
    }
    ?>
</div>