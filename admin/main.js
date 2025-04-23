/* đăng nhập*/
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('.form-login');
    form.addEventListener("submit",function(event)
    { 
        let username = document.querySelector(".username").value.trim();
        let password = document.querySelector(".password").value.trim();
        let message = document.querySelector(".message");
        let check = true;
        message.innerText="";
        if (username === "" || password === "") {
            message.innerText = "Vui lòng nhập đầy đủ!";
            check = false;
        }
        if(!check)
        {
            event.preventDefault();
        }
    });
    });
    
// trang quản lý product 
// đồng hồ
document.addEventListener('DOMContentLoaded', function () {
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const formattedDate = now.toLocaleString('vi-VN', options);
        document.getElementById('datetime').textContent = formattedDate;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
})

// Quản lý sản phẩm
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
        const imageExtensions = /\.(jpg|webp|jpeg|png|gif)$/i;

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
            message.innerText = "Ảnh phải là file jpg,webp, jpeg, png hoặc gif.";
        }
        if (!isValid) {
            e.preventDefault(); // Chỉ chặn submit nếu có lỗi
        }
    });
});
//chinh sửa product
document.addEventListener('DOMContentLoaded', function() {
const form = document.querySelector('.form-edit-product');
form.addEventListener('submit', function(e) {
let isValid = true;
let errors = [];
let message = document.querySelector(".message-product");
message.innerText = "";

const anh1File = form.querySelector('input[name="anh1"]').files[0];
const anh2File = form.querySelector('input[name="anh2"]').files[0];
const anh3File = form.querySelector('input[name="anh3"]').files[0];
const imageExtensions = /\.(jpg|webp|jpeg|png|gif)$/i;

if (anh1File && !imageExtensions.test(anh1File.name)) {
    isValid = false;
    errors.push("Ảnh 1 phải là file jpg, webp, jpeg, png hoặc gif.");
}

if (anh2File && !imageExtensions.test(anh2File.name)) {
    isValid = false;
    errors.push("Ảnh 2 phải là file jpg, webp, jpeg, png hoặc gif.");
}

if (anh3File && !imageExtensions.test(anh3File.name)) {
    isValid = false;
    errors.push("Ảnh 3 phải là file jpg, webp, jpeg, png hoặc gif.");
}

if (!isValid) {
    e.preventDefault(); // chặn submit
    message.innerText = errors.join("\n"); // nối lỗi lại, mỗi lỗi 1 dòng
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
// Quản lý User
//Tạo user
document.addEventListener('DOMContentLoaded',function(){
const create = document.querySelector('.form-create-user');
create.addEventListener('submit',function(e){
    let isValid = true;
    let message = document.querySelector(".message-product");
    message.innerText = "";
    const hoten = create.querySelector('input[name="hoten"]').value.trim();
    const sodienthoai = create.querySelector('input[name="sodienthoai"]').value.trim();
    const username = create.querySelector('input[name="username"]').value.trim();
    const password = create.querySelector('input[name="password"]').value.trim();
    const diachi = create.querySelector('input[name="diachi"]').value.trim();
    const vaitro = create.querySelector('select[name="vaitro"]').value;

    
    if (!hoten || !sodienthoai || !username || !password || !diachi || !vaitro) {
        isValid = false;
        message.innerText = "Vui lòng điền đầy đủ!.\n";
    }
    const phoneRegex = /^[0-9]{9,11}$/;
    if (!phoneRegex.test(sodienthoai)) {
        isValid = false;
        message.innerText += "Số điện thoại không hợp lệ. Phải là 9-11 chữ số.\n";
    }
    const validCharRegex = /^[a-zA-Z0-9]+$/;
    if (!validCharRegex.test(username)) {
        isValid = false;
        message.innerText += "Username không được chứa ký tự đặc biệt.\n";
    }

    if (!validCharRegex.test(password)) {
        isValid = false;
        message.innerText += "Password không được chứa ký tự đặc biệt.\n";
    }

    if (!isValid) {
    
        e.preventDefault(); 
    }
});
});
// chỉnh sủa User
document.addEventListener('DOMContentLoaded',function(){
    const create = document.querySelector('.form-edit-user');
    create.addEventListener('submit',function(e){
        let isValid = true;
        let message = document.querySelector(".message-product");
        message.innerText = "";
        const sodienthoai = create.querySelector('input[name="sodienthoai"]').value.trim();
        const username = create.querySelector('input[name="username"]').value.trim();
        const password = create.querySelector('input[name="password"]').value.trim();
        const validCharRegex = /^[a-zA-Z0-9]+$/;
        const phoneRegex = /^[0-9]{9,11}$/;
        if(username&&!validCharRegex.test(username))
        {
            isValid = false;
            message.innerText += "Username không được chứa ký tự đặc biệt.\n";
        }
        if(password&&!validCharRegex.test(password))
        {
            isValid = false;
            message.innerText += "Password không được chứa ký tự đặc biệt.\n";
        }
        
        if (sodienthoai&&!phoneRegex.test(sodienthoai)) {
            isValid = false;
            message.innerText += "Số điện thoại không hợp lệ. Phải là 9-11 chữ số.\n";
        }
        if (!isValid) {
        
            e.preventDefault(); 
        }
    });
    });
//xóa user
document.addEventListener('DOMContentLoaded', function () {
    const msgBox = document.querySelector('.toast-alert');
    if (msgBox) {
        setTimeout(function () {
            msgBox.classList.add('fade-out');
            setTimeout(function () {
                msgBox.style.display = 'none';
            }, 500);
        }, 1000);
    }
});
//xắp xêp
    // function applySort(value)
    // {
    //     const urlParams = new URLSearchParams(window.location.search);
    //     urlParams.set("sort",value);
    //     window.location.href = window.location.pathname + "?" +urlParams.toString();

    // }
    function applySort(value) {
        const params = new URLSearchParams(window.location.search);
        params.set('sort', value);
        // giữ lại keyword nếu có
        if (!params.get('keyword')) params.set('keyword', '');
        // quay lại trang 1 khi đổi thương hiệu
        params.set('page', 1); 
        window.location.href = '?' + params.toString();
    }