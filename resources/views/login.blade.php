<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập hệ thống</title>

    @vite(['resources/css/auth/login.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="logo">
                <img src="{{asset('images/logo.png')}}" alt="Logo">
            </div>

            <h2>Đăng nhập hệ thống</h2>

            <div id="error-message" class="alert alert-danger" style="display: none;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="error-text"></span>
            </div>
            <div id="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Nhập địa chỉ email" required>
                    </div>
                    <span class="text-danger" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                    <span class="text-danger" id="password-error"></span>
                </div>

                <button type="button" id="btn-login" class="btn-login">
                    <span id="btn-text">Đăng nhập</span>
                    <i id="btn-spinner" class="fas fa-spinner fa-spin" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    @vite(['resources/js/auth/login.js'])
</body>

</html>