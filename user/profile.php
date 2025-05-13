<?php
require_once '../database/database.php';
session_start();

// if (!isset($_SESSION['user_id'])) {
//     die("User not logged in.");
// }

$conn = getDBConnection();
$user_id = $_SESSION['user_id'] ?? '';
$firstname = $_SESSION['user_firstname'] ?? 'Guest';
$lastname = $_SESSION['user_lastname'] ?? 'Guest';
$username = $_SESSION['user_username'] ?? 'Guest';
$email = $_SESSION['user_email'] ?? 'Guest';
$_SESSION['profile_picture'] = $_SESSION['profile_picture'] ?? 'default.jpg';

$address = '';
$contact_number = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'], $_POST['contact_number'])) {
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $stmt = $conn->prepare("SELECT id FROM users_profile WHERE users_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $stmt = $conn->prepare("UPDATE users_profile SET address = ?, contact_number = ? WHERE users_id = ?");
        $stmt->bind_param("ssi", $address, $contact_number, $user_id);
        $stmt->execute();
    } else {
        // Insert new profile
        $stmt = $conn->prepare("INSERT INTO users_profile (users_id, address, contact_number) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $address, $contact_number);
        $stmt->execute();
    }

    $_SESSION['address_message'] = "Profile updated successfully.";
    $_SESSION['address_status'] = "success";
    header("Location: profile.php#addresses");
    exit;
}

// Load existing profile data
$stmt = $conn->prepare("SELECT address, contact_number FROM users_profile WHERE users_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($profile = $result->fetch_assoc()) {
    $address = $profile['address'] ?? '';
    $contact_number = $profile['contact_number'] ?? '';
}
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Peasy</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="../guest/index.css">
    <link rel="stylesheet" href="profile.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                        <i class="bi bi-person-fill-gear fs-1 mx-2"></i>
                            <!-- <img src="/api/placeholder/200/200" alt="Profile Picture" class="profile-picture mb-3">
                            <label for="profile-upload"
                                class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm edit-icon">
                                <i class="bi bi-camera"></i>
                            </label>
                            <input type="file" id="profile-upload" class="d-none"> -->
                        </div>
                        <h5 class="mb-1">
                            <?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_firstname'])) {
                echo htmlspecialchars($_SESSION['user_firstname']);
            } else {
                echo 'Login';
            }
            ?>
                        </h5>
                        <p class="text-muted mb-3">
                            <?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_lastname'])) {
                echo htmlspecialchars($_SESSION['user_lastname']);
            } else {
                echo 'Login';
            }
            ?>
                        </p>
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
                            <button class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#signOutModal">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
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
                                                <input type="text" class="form-control" value="<?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_firstname'])) {
                echo htmlspecialchars($_SESSION['user_firstname']);
            } else {
                echo 'Login';
            }
            ?>" disabled>
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
                                                <input type="text" class="form-control" value="<?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_lastname'])) {
                echo htmlspecialchars($_SESSION['user_lastname']);
            } else {
                echo 'Login';
            }
            ?>" disabled>
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
                                                <input type="text" class="form-control" value="<?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_username'])) {
                echo htmlspecialchars($_SESSION['user_username']);
            } else {
                echo 'Login';
            }
            ?>" disabled>
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
                                                <input type="email" class="form-control" value="
                                                <?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_email'])) {
                echo htmlspecialchars($_SESSION['user_email']);
            } else {
                echo 'Login';
            }
            ?>" disabled>
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
                                                <input type="tel" class="form-control" value="" disabled>
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
                                                <input type="date" class="form-control" value="" disabled>
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
                                        <p>Add an extra layer of security to your account by enabling two-factor
                                            authentication.</p>
                                        <button class="btn btn-outline-success" disabled>Set Up Two-Factor</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Addresses Tab -->
                            <div class="tab-pane fade" id="addresses">
                            <div class="container mt-4" id="addresses">
    <!-- Show feedback messages if they exist -->
    <?php if (isset($_SESSION['address_message'])): ?>
        <div class="alert alert-<?= $_SESSION['address_status'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['address_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
        // Clear the message after displaying it
        unset($_SESSION['address_message']); 
        unset($_SESSION['address_status']);
        ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">My Addresses</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="bi bi-plus-lg me-1"></i> Add New Address
        </button>
    </div>

    <?php if (empty($address) && empty($contact_number)): ?>
        <div class="alert alert-info">You have not set a default address or contact number. Please add one below.</div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Default Address</h5>
            <?php if ($address || $contact_number): ?>
                <span class="badge bg-success">Saved</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> <?= htmlspecialchars($firstname . ' ' . $lastname) ?></p>
            <p><strong>Address:</strong> <?= $address ? htmlspecialchars($address) : 'Not set' ?></p>
            <p><strong>Contact Number:</strong> <?= $contact_number ? htmlspecialchars($contact_number) : 'Not set' ?></p>
    
            <button class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                <?= ($address || $contact_number) ? 'Edit' : 'Add' ?> Address
            </button>
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
                                                    <img src="/api/placeholder/150/150" class="img-fluid rounded-start"
                                                        alt="Product">
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Product Name 1</h5>
                                                        <p class="card-text text-success fw-bold">$59.99</p>
                                                        <div class="d-flex">
                                                            <button class="btn btn-sm btn-success me-2">Add to
                                                                Cart</button>
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
                                                    <img src="/api/placeholder/150/150" class="img-fluid rounded-start"
                                                        alt="Product">
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Product Name 2</h5>
                                                        <p class="card-text text-success fw-bold">$29.99</p>
                                                        <div class="d-flex">
                                                            <button class="btn btn-sm btn-success me-2">Add to
                                                                Cart</button>
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
    <div class="modal fade" id="signOutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Sign Out Confirmation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class="bi bi-question-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Are you sure you want to sign out?</h5>
                    <p class="text-muted mb-0">You will be redirected to the guest page.</p>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Cancel
                    </button>
                    <a href="../guest/index.php" class="btn btn-danger">
                        <i class="bi bi-check-lg me-2"></i>Yes, Sign Out
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="profile.php#addresses">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control" required><?php echo htmlspecialchars($address); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control" required value="<?php echo htmlspecialchars($contact_number); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <footer class="bg-dark text-white py-4 mt-5 m" >
        <div class="container" style="margin-top: 10%;">
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
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-VpGV...YOUR_HASH..." crossorigin="anonymous"></script>

</body>

</html>