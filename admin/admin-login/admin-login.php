
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="admin-login-style.css">
    <title>Admin Login - Peasy System</title>
</head>
<body>
    <div class="container">
        <div class="login-card mx-auto">
            <div class="text-center mb-4">
                <img src="../../admin/admin-panel/images/logo.png" alt="Peasy Logo" class="brand-logo">
                <h2 class="text-success mb-3">Admin Login</h2>
            </div>
            <!-- <form method="POST" action="admin-auth.php"> -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-success text-white">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" 
                               name="username" 
                               class="form-control border-success" 
                               placeholder="Username" 
                               required>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-success text-white">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               class="form-control border-success" 
                               placeholder="Password" 
                               required>
                        <button class="btn btn-outline-success" 
                                type="button" 
                                onclick="togglePassword()">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>
                <a href="../admin-panel/views/index.php" class="btn btn-success w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2">
                    </i>Login</a>
                <!-- <button type="submit" 
                        class="btn btn-success w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </form> -->
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const icon = document.querySelector('.bi-eye-fill');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        }
    </script>
</body>
</html>