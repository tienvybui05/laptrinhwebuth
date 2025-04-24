
function showNotification(message) {
    var notification = document.createElement('div');
    notification.classList.add('notification');
    notification.innerText = message;
    document.body.appendChild(notification);

    // Tự động ẩn thông báo sau 3 giây
    setTimeout(function () {
        notification.remove();
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
    const formInfo = document.querySelector('.info-user');
    const formPassword = document.querySelector('.change-password');
    const saveInfoButton = document.querySelector('#save-info-user');
    const savePasswordButton = document.querySelector('#save-password');

    // Lưu giá trị ban đầu của các trường
    const initialInfoValues = {
        infoname: document.querySelector('#infoname').value,
        infoSoDienThoai: document.querySelector('#infoemail').value,
        infoaddress: document.querySelector('#infoaddress').value
    };

    const initialPasswordValues = {
        passwordOld: '',
        passwordNew: '',
        confirmPassword: ''
    };

    // Hàm kiểm tra sự thay đổi trong form thông tin
    function checkInfoChanges() {
        const currentValues = {
            infoname: document.querySelector('#infoname').value,
            infoSoDienThoai: document.querySelector('#infoemail').value,
            infoaddress: document.querySelector('#infoaddress').value
        };

        const hasChanges = Object.keys(initialInfoValues).some(key => initialInfoValues[key] !== currentValues[key]);
        saveInfoButton.disabled = !hasChanges; // Vô hiệu hóa nếu không có thay đổi
    }

    // Hàm kiểm tra sự thay đổi trong form mật khẩu
    function checkPasswordChanges() {
        const currentValues = {
            passwordOld: document.querySelector('#password-cur-info').value,
            passwordNew: document.querySelector('#password-after-info').value,
            confirmPassword: document.querySelector('#password-comfirm-info').value
        };

        const hasChanges = Object.keys(initialPasswordValues).some(key => initialPasswordValues[key] !== currentValues[key]);
        savePasswordButton.disabled = !hasChanges; // Vô hiệu hóa nếu không có thay đổi
    }

    // Gắn sự kiện input vào các trường trong form thông tin
    formInfo.addEventListener('input', checkInfoChanges);

    // Gắn sự kiện input vào các trường trong form mật khẩu
    formPassword.addEventListener('input', checkPasswordChanges);

    // Vô hiệu hóa nút submit ban đầu
    saveInfoButton.disabled = true;
    savePasswordButton.disabled = true;
});

document.addEventListener('DOMContentLoaded', function () {
    // Lấy các trường input và các phần tử hiển thị lỗi
    const infonameInput = document.querySelector('#infoname');
    const infoemailInput = document.querySelector('#infoemail');
    const infoaddressInput = document.querySelector('#infoaddress');

    const errorInfoname = document.getElementById('error-infoname');
    const errorInfoemail = document.getElementById('error-infoemail');
    const errorInfoaddress = document.getElementById('error-infoaddress');

    // Kiểm tra họ và tên
    infonameInput.addEventListener('blur', function () {
        const value = infonameInput.value.trim();
        if (!value) {
            errorInfoname.innerText = 'Họ và tên không được để trống.';
        } else {
            errorInfoname.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
    });

    // Kiểm tra số điện thoại
    infoemailInput.addEventListener('blur', function () {
        const value = infoemailInput.value.trim();
        const phoneRegex = /^[0-9]{9,11}$/;
        if (!value) {
            errorInfoemail.innerText = 'Số điện thoại không được để trống!';
        } else if (!phoneRegex.test(value)) {
            errorInfoemail.innerText = 'Số điện thoại không hợp lệ! Phải là 9-11 chữ số.';
        } else {
            errorInfoemail.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
    });

    // Kiểm tra địa chỉ
    infoaddressInput.addEventListener('blur', function () {
        const value = infoaddressInput.value.trim();
        if (!value) {
            errorInfoaddress.innerText = 'Địa chỉ không được để trống.';
        } else {
            errorInfoaddress.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
    });
});

function validatePassword() {
    let isValid = true;

    // Kiểm tra mật khẩu cũ không được để trống
    if (!passwordOldInput.value.trim()) {
        errorPasswordOld.innerText = 'Mật khẩu hiện tại không được để trống.';
        isValid = false;
    } else if (!isPasswordOldCorrect(passwordOldInput.value.trim())) { // Kiểm tra mật khẩu cũ có đúng không
        errorPasswordOld.innerText = 'Mật khẩu hiện tại không đúng.';
        isValid = false;
    } else {
        errorPasswordOld.innerText = '';
    }

    // Kiểm tra mật khẩu mới không được để trống
    if (!passwordNewInput.value.trim()) {
        errorPasswordNew.innerText = 'Mật khẩu mới không được để trống.';
        isValid = false;
    } else {
        errorPasswordNew.innerText = '';
    }

    // Kiểm tra xác nhận mật khẩu mới phải trùng với mật khẩu mới
    if (passwordNewInput.value.trim() !== confirmPasswordInput.value.trim()) {
        errorConfirmPassword.innerText = 'Xác nhận mật khẩu mới không khớp.';
        isValid = false;
    } else {
        errorConfirmPassword.innerText = '';
    }

    // Vô hiệu hóa nút submit nếu không hợp lệ
    savePasswordButton.disabled = !isValid;
}

// Hàm giả lập kiểm tra mật khẩu cũ có đúng không
function isPasswordOldCorrect(passwordOld) {
    // Thay thế đoạn này bằng logic kiểm tra thực tế (ví dụ: gọi API)
    const correctPassword = "123456"; // Mật khẩu cũ đúng (giả lập)
    return passwordOld === correctPassword;
}

// Gắn sự kiện `input` để kiểm tra khi người dùng nhập
passwordOldInput.addEventListener('input', validatePassword);
passwordNewInput.addEventListener('input', validatePassword);
confirmPasswordInput.addEventListener('input', validatePassword);

// Vô hiệu hóa nút submit ban đầu
savePasswordButton.disabled = true;
