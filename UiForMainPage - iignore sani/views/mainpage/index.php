<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap 5 JS with Popper (MUST be a <script>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <title>Document</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid ms-5 ps-5 me-5 pe-5">
        <img src="../../assets/hacker.png" alt="Logo" width="30" height="30">
        <a class="navbar-brand text-light" href="#"><h3>PEasy</h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-light" href="#">Gallery</a>
            </li>
        </ul>
        <div class="d-flex">
            <a href="#" class="btn btn-outline-light me-2">
            <i class="fas fa-search"></i>
            </a>
            <a href="#" class="btn btn-outline-light me-2">
            <i class="fas fa-user"></i>
            </a>
            <a href="#" class="btn btn-outline-light position-relative">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
            </span>
            </a>
        </div>
        </div>
    </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Premium Tech for Your Digital Life</h1>
            <p class="lead mb-5">Discover the latest computers, components, and accessories at unbeatable prices</p>
            <a href="#products" class="btn btn-primary btn-lg px-4 me-2">Shop Now</a>
            <a href="#" class="btn btn-outline-light btn-lg px-4">Learn More</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <button class="category-btn btn btn-outline-secondary w-100 py-3" data-category="laptops">
                        <i class="fas fa-laptop fa-2x mb-2"></i>
                        <h5>Laptops</h5>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="category-btn btn btn-outline-secondary w-100 py-3" data-category="desktops">
                        <i class="fas fa-desktop fa-2x mb-2"></i>
                        <h5>Desktops</h5>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="category-btn btn btn-outline-secondary w-100 py-3" data-category="components">
                        <i class="fas fa-microchip fa-2x mb-2"></i>
                        <h5>Components</h5>
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <button class="category-btn btn btn-outline-secondary w-100 py-3" data-category="accessories">
                        <i class="fas fa-keyboard fa-2x mb-2"></i>
                        <h5>Accessories</h5>
                    </button>
                </div>
            </div>
        </div>
    </section>
</body>
</html>