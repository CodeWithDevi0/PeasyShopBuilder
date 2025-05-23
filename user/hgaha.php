
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Peasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .profile-sidebar {
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            height: 100%;
        }
        
        .profile-sidebar .nav-link {
            color: #495057;
            border-radius: 0;
            padding: 12px 20px;
        }
        
        .profile-sidebar .nav-link:hover,
        .profile-sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #198754;
        }
        
        .profile-sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .profile-picture {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .profile-header {
            background-color: #f1f8f3;
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 500;
        }
        
        .btn-success {
            background-color: #198754;
        }
        
        .edit-icon {
            cursor: pointer;
            color: #6c757d;
        }
        
        .edit-icon:hover {
            color: #198754;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-success px-4 py-2">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="">
                <img src="../assets/nobg.png" alt="Logo" width="60" height="60" class="me-2">
                <strong class="text-white">PEasy</strong>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="userCart.php"><i class="bi bi-cart fs-4"></i></a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#"><i class="bi bi-chat-left fs-4"></i></a>
                    </li>
                    <li class="nav-item mx-2 ">
                        <a class="nav-link text-white d-flex align-items-center just"
                            href="<?php echo isset($_SESSION['user_logged_in']) ? 'profile.php' : '/Authentication/signIn/login.php'; ?>">
                            <i class="bi bi-person-circle fs-4 mx-2"></i>
                            <span>
                                <?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_firstname'])) {
                echo htmlspecialchars($_SESSION['user_firstname']);
            } else {
                echo 'Login';
            }
            ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="profile-sidebar rounded p-3">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="/api/placeholder/200/200" alt="Profile Picture" class="profile-picture mb-3">
                            <label for="profile-upload" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm edit-icon">
                                <i class="bi bi-camera"></i>
                            </label>
                            <input type="file" id="profile-upload" class="d-none">
                        </div>
                        <h5 class="mb-1">John Doe</h5>
                        <p class="text-muted mb-3">@johndoe</p>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#personal-info" data-bs-toggle="tab">
                                <i class="bi bi-person"></i> Personal Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#security" data-bs-toggle="tab">
                                <i class="bi bi-shield-lock"></i> Security
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#addresses" data-bs-toggle="tab">
                                <i class="bi bi-geo-alt"></i> Addresses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#orders" data-bs-toggle="tab">
                                <i class="bi bi-bag"></i> My Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wishlist" data-bs-toggle="tab">
                                <i class="bi bi-heart"></i> Wishlist
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- Personal Information Tab -->
                            <div class="tab-pane fade show active" id="personal-info">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Personal Information</h4>
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-pencil me-1"></i> Edit Profile
                                    </button>
                                </div>

                                <div class="row g-4">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="John" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="Doe" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Username -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="johndoe" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <input type="email" class="form-control" value="john.doe@example.com" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <input type="tel" class="form-control" value="+1 (555) 123-4567" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" value="1990-01-15" disabled>
                                                <span class="input-group-text edit-icon">
                                                    <i class="bi bi-pencil"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane fade" id="security">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Security Settings</h4>
                                </div>

                                <!-- Change Password Section -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label">Current Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" value="••••••••">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success">Update Password</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Two-Factor Authentication -->
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Two-Factor Authentication</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="twoFactorToggle">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Add an extra layer of security to your account by enabling two-factor authentication.</p>
                                        <button class="btn btn-outline-success" disabled>Set Up Two-Factor</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Addresses Tab -->
                            <div class="tab-pane fade" id="addresses">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">My Addresses</h4>
                                    <button class="btn btn-success">
                                        <i class="bi bi-plus-lg me-1"></i> Add New Address
                                    </button>
                                </div>

                                <!-- Default Address -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Default Address</h5>
                                        <span class="badge bg-success">Default</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>John Doe</strong></p>
                                                <p>123 Main Street, Apt 4B</p>
                                                <p>New York, NY 10001</p>
                                                <p>United States</p>
                                                <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                                            </div>
                                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                                <button class="btn btn-outline-success me-2">
                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Address -->
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Work Address</h5>
                                        <button class="btn btn-sm btn-outline-success">Set as Default</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>John Doe</strong></p>
                                                <p>456 Business Ave, Suite 200</p>
                                                <p>New York, NY 10022</p>
                                                <p>United States</p>
                                                <p><strong>Phone:</strong> +1 (555) 987-6543</p>
                                            </div>
                                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                                <button class="btn btn-outline-success me-2">
                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Orders Tab -->
                            <div class="tab-pane fade" id="orders">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">My Orders</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Date</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#PE12345</td>
                                                <td>May 2, 2025</td>
                                                <td>3 items</td>
                                                <td>$125.99</td>
                                                <td><span class="badge bg-success">Delivered</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-success">View Details</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#PE12344</td>
                                                <td>Apr 25, 2025</td>
                                                <td>1 item</td>
                                                <td>$49.99</td>
                                                <td><span class="badge bg-warning text-dark">Shipped</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-success">View Details</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#PE12343</td>
                                                <td>Apr 15, 2025</td>
                                                <td>2 items</td>
                                                <td>$79.98</td>
                                                <td><span class="badge bg-success">Delivered</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-success">View Details</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Wishlist Tab -->
                            <div class="tab-pane fade" id="wishlist">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">My Wishlist</h4>
                                </div>

                                <div class="row g-4">
                                    <!-- Wishlist Item 1 -->
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="row g-0">
                                                <div class="col-4">
                                                    <img src="/api/placeholder/150/150" class="img-fluid rounded-start" alt="Product">
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Product Name 1</h5>
                                                        <p class="card-text text-success fw-bold">$59.99</p>
                                                        <div class="d-flex">
                                                            <button class="btn btn-sm btn-success me-2">Add to Cart</button>
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Wishlist Item 2 -->
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="row g-0">
                                                <div class="col-4">
                                                    <img src="/api/placeholder/150/150" class="img-fluid rounded-start" alt="Product">
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Product Name 2</h5>
                                                        <p class="card-text text-success fw-bold">$29.99</p>
                                                        <div class="d-flex">
                                                            <button class="btn btn-sm btn-success me-2">Add to Cart</button>
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>PEasy</h5>
                    <p>Your one-stop shop for all your needs.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">Contact Us</a></li>
                        <li><a href="#" class="text-white">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Connect With Us</h5>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; 2025 PEasy. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        // Simple JavaScript to make the tabs work
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.nav-link');
            
            tabLinks.forEach(tabLink => {
                tabLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(link => {
                        link.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Get the target tab from href attribute
                    const targetId = this.getAttribute('href');
                    
                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });
                    
                    // Show the target tab pane
                    if (targetId && targetId !== '#') {
                        const targetPane = document.querySelector(targetId);
                        if (targetPane) {
                            targetPane.classList.add('show', 'active');
                        }
                    }
                });
            });
            
            // Toggle password visibility
            const eyeIcons = document.querySelectorAll('.bi-eye, .bi-eye-slash');
            eyeIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.parentNode.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    }
                });
            });
        });
    </script>
</body>

</html>