document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");

    form.addEventListener("submit", function (event) {
        let hasError = false;

        // Xóa lỗi cũ
        document.querySelectorAll(".error").forEach(error => error.style.display = "none");

        // Lấy giá trị input
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Kiểm tra tên đăng nhập
        if (username === "") {
            document.getElementById("error-username").textContent = "Vui lòng nhập tên đăng nhập!";
            document.getElementById("error-username").style.display = "block";
            hasError = true;
        }

        // Kiểm tra email
        if (email === "") {
            document.getElementById("error-email").textContent = "Vui lòng nhập email!";
            document.getElementById("error-email").style.display = "block";
            hasError = true;
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            document.getElementById("error-email").textContent = "Email không hợp lệ!";
            document.getElementById("error-email").style.display = "block";
            hasError = true;
        }

        // Kiểm tra mật khẩu
        if (password === "") {
            document.getElementById("error-password").textContent = "Vui lòng nhập mật khẩu!";
            document.getElementById("error-password").style.display = "block";
            hasError = true;
        } else if (password.length < 6) {
            document.getElementById("error-password").textContent = "Mật khẩu phải có ít nhất 6 ký tự!";
            document.getElementById("error-password").style.display = "block";
            hasError = true;
        }

        // Nếu có lỗi, ngăn form gửi đi
        if (hasError) {
            event.preventDefault();
        }
    });
});
