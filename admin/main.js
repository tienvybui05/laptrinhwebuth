// trang quản lý product 
//- tạo product 
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('.form-create-product');
    form.addEventListener('submit', function (e) {
        let isValid = true;
        let message = document.querySelector(".message-product");
        message.innerText = "";

        const tenSanPham = form.querySelector('input[name="tensanpham"]').value.trim();
        const thuongHieu = form.querySelector('input[name="thuonghieu"]').value.trim();
        const khuyenMai = form.querySelector('input[name="khuyenmai"]').value.trim();
        const gia = form.querySelector('input[name="gia"]').value.trim();
        const moTa = form.querySelector('textarea[name="mota"]').value.trim();
        const tonKho = form.querySelector('input[name="tonkho"]').value.trim();
        const doCung = form.querySelector('input[name="docung"]').value.trim();
        const diemCanBang = form.querySelector('input[name="diemcanbang"]').value.trim();
        const trinhDo = form.querySelector('input[name="trinhdo"]').value.trim();
        const trongLuong = form.querySelector('input[name="trongluong"]').value.trim();

        const anh1File = form.querySelector('input[name="anh1"]').files[0];
        const anh2File = form.querySelector('input[name="anh2"]').files[0];
        const anh3File = form.querySelector('input[name="anh3"]').files[0];
        const imageExtensions = /\.(jpg|jpeg|png|gif)$/i;

        if (
            !tenSanPham || !thuongHieu || !khuyenMai || !gia || !moTa || !tonKho ||
            !doCung || !diemCanBang || !trinhDo || !trongLuong ||
            !anh1File || !anh2File || !anh3File
        ) {
            isValid = false;
            message.innerText = "Vui lòng nhập đầy đủ thông tin!";
        } else if (
            !imageExtensions.test(anh1File.name) ||
            !imageExtensions.test(anh2File.name) ||
            !imageExtensions.test(anh3File.name)
        ) {
            isValid = false;
            message.innerText = "Ảnh phải là file jpg, jpeg, png hoặc gif.";
        }
        if (!isValid) {
            e.preventDefault(); // Chỉ chặn submit nếu có lỗi
        }
    });
});
// Xóa product
document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('.xoa-product');

    deleteLinks.forEach(function(link) {
        const parentTd = link.closest('.hanh-dong');
        const modal = parentTd.querySelector('.xoa-confirmModal');
        const cancelBtn = modal.querySelector('.xoa-cancelBtn');
        const confirmBtn = modal.querySelector('.xoa-confirmBtn');
        const deleteUrl = link.dataset.url;// lấy đường link từ thẻ a

        link.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.add('active');
        });

        cancelBtn.addEventListener('click', function () { // bấm nút hủy thì xóa class active
            modal.classList.remove('active');
        });

        confirmBtn.addEventListener('click', function () {// bấm nút xóa thì dẫn sang trang mới
            window.location.href = deleteUrl;
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    });
});


/* đăng nhập*/
document.addEventListener("DOMContentLoaded", function () {
document.querySelector(".form-login").addEventListener("submit",function(event)
{
    event.preventDefault()// ngăn chặn tải lại trăng
    let username = document.querySelector(".username").value.trim();
    let password = document.querySelector(".password").value.trim();
    let message = document.querySelector(".message");
    message.innerText="";
    if (username === "" || password === "") {
        message.innerText = "Đăng nhập không hợp lệ, vui lòng thử lại!";
        return;
    }
    // chừng có php thì code phần xử lý tiếp
});
});
