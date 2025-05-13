<?php
require_once '../database/database.php';

session_start();
// Database connection
$db_host = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "peasy";
$db_port = 3306;

$conn = new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
$conn = getDBConnection();
$user_id = $_SESSION['user_id'] ?? '';
$firstname = $_SESSION['user_firstname'] ?? 'Guest';
$lastname = $_SESSION['user_lastname'] ?? 'Guest';
$username = $_SESSION['user_username'] ?? 'Guest';
$email = $_SESSION['user_email'] ?? 'Guest';
$_SESSION['profile_picture'] = $_SESSION['profile_picture'] ?? 'default.jpg';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Peasy </title>
  <link rel="stylesheet" href="../guest/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
    <li class="nav-item">
      <a class="nav-link text-dark" aria-current="page" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-dark" href="build.php">Build A PC</a>
    </li>
    <li class="nav-item nav-pills">
      <a class="nav-link active bg-success" href="laptops.php">Laptops</a>
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
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
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
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="kunwari-IT text-center">
    <p class="fs-1">
      Under constructions pani boss (wala pa natagaag budget sa national)
    </p>
    <p class="fs-2 text-dark">ikawparin
    </p>
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