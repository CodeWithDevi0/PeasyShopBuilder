<?php
require_once '../database/database.php';
session_start();
// if (!isset($_SESSION['user_id'])) {
//     $_SESSION['user_id'] = 123;
//     echo "Session started and user_id set.";
// } else {
//     echo "User ID is still set: " . $_SESSION['user_id'];
// }   

// Database connection
$db_host = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "demopeasy";
$db_port = 3306;

$conn = new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
$products = $conn->query("SELECT * FROM products");

// Redundant, but keeping if needed elsewhere
$conn = getDBConnection();
$user_id = $_SESSION['user_id'] ?? '';
$firstname = $_SESSION['user_firstname'] ?? 'Guest';
$lastname = $_SESSION['user_lastname'] ?? 'Guest';
$username = $_SESSION['user_username'] ?? 'Guest';
$email = $_SESSION['user_email'] ?? 'Guest';
$_SESSION['profile_picture'] = $_SESSION['profile_picture'] ?? 'default.jpg';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'], $_POST['contact_number'])) {
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $stmt = $conn->prepare("SELECT id FROM users_profile WHERE users_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Main | Peasy</title>
    <link rel="stylesheet" href="../guest/index.css">
    <link rel="stylesheet" href="../guest/priceList.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

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
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white d-flex align-items-center"
                            href="<?php echo isset($_SESSION['user_logged_in']) ? 'profile.php' : '/Authentication/signIn/login.php'; ?>">
                            <i class="bi bi-person-circle fs-4 mx-2"></i>
                            <span>
                                <?php echo isset($_SESSION['user_logged_in']) && isset($_SESSION['user_firstname']) 
                                    ? htmlspecialchars($_SESSION['user_firstname']) 
                                    : 'Login'; ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--navigation ni boss-->
    <ul class="nav fs-5 justify-content-center mt-2">
        <li class="nav-item nav-pills ">
            <a class="nav-link active bg-success" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="build.php">Build A PC</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="#">Laptops</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="computers.php">Computers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="priceList.php">Price List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled text-dark" aria-disabled="true">Disabled</a>
        </li>
    </ul>

    <div class="container my-4">
        <!-- carousel here -->


        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="../assets/mainCarousel.png" class="d-block w-100" alt="..." width="780" height="450"
                        style="max-height: 450px; object-fit: cover;">

                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="../assets/carouselCase.png" class="d-block w-100" alt="..." width="780" height="450"
                        style="max-height: 450px; object-fit: cover;">

                </div>
                <div class="carousel-item">
                    <img src="../assets/acerCAROUSEL.png" class="d-block w-100" alt="..." width="780" height="450"
                        style="max-height: 450px; object-fit: cover;">

                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container py-4">
        <h2 class="bi bi-box-seam-fill text-center"> Available Products</h2>
        <div class="row mt-4">
            <?php while ($p = $products->fetch_assoc()): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <?php
                    $imagePath = $p['image'];
                    if (!filter_var($imagePath, FILTER_VALIDATE_URL)) {
                        $imagePath = "assets/" . ltrim($imagePath, '/');
                    }
                    ?>
                    <img src="../<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="Product Image"
                        style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center"><?= htmlspecialchars($p['name']) ?></h5>
                        <p class="card-text small text-muted text-center"><?= htmlspecialchars($p['description']) ?></p>
                        <p class="text-center fw-bold text-success mb-3">₱<?= number_format($p['price'], 2) ?></p>
                        <form method="post" action="userCart.php" class="mt-auto">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <button class="btn btn-success w-100" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>



    <footer class="bg-dark text-white py-4 mt-5 m">
        <div class="container" style="margin-top: 5%;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>