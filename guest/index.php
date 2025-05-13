<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Peasy </title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body> 
<nav class="navbar navbar-expand-lg bg-success px-4 py-2">
  <div class="container-fluid">
    <!-- Logo and Brand -->
    <a class="navbar-brand d-flex align-items-center text-white" href="#">
      <img src="../assets/nobg.png" alt="Logo" width="60" height="60" class="me-2">
      <strong>PEasy</strong>
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Right Nav Icons -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-bag fs-4"></i></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-chat-left fs-4"></i></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white d-flex align-items-center" href="../Authentication/signIn/login.php">
            <i class="bi bi-person-fill-exclamation fs-3 me-1"></i> <span>Login</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="../Authentication/register/create.php">
            <i class="bi bi-person-exclamation fs-3 me-1"></i> <span>Register</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!--navigation ni boss-->
<ul class="nav fs-5 justify-content-center mt-2">
  <li class="nav-item nav-pills ">
    <a class="nav-link active bg-success" aria-current="page" href="../guest/index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="../guest/build.php">Build A PC</a>
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
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="../assets/mainCarousel.png" class="d-block w-100" alt="..." width="780" height="450" style="max-height: 450px; object-fit: cover;"> 
    
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="../assets/carouselCase.png" class="d-block w-100" alt="..." width="780" height="450" style="max-height: 450px; object-fit: cover;">
   
    </div>
    <div class="carousel-item">
      <img src="../assets/acerCAROUSEL.png" class="d-block w-100" alt="..." width="780" height="450" style="max-height: 450px; object-fit: cover;">
     
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

<div class="product-container">
    <div class="product-card">
      <img src="../assets/GIGABYTEP650G.png" alt="Product Image">
      <div class="product-info">
        <h3 class="product-title">Power Supply</h3>
        <p class="product-description">A Mid-ranged power supply with 80+ gold rated.</p>
        <p class="product-price">₱3,000</p>
        <a href="../signIn/login.php" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</a>
        <a href="../signIn/login.php" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
      </div>
  </div>
    <div class="product-card">
      <img src="../assets/segotepW1.png" alt="Product Image">
      <div class="product-info">
        <h3 class="product-title">Segotep W1 PC Case</h3>
        <p class="product-description">RGB Mid-tower with tempered glass side panel.</p>
        <p class="product-price">₱1,400</p>
        <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</a>
        <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
      </div>
    </div>
    <div class="product-card" style="padding-top: 20px;">
      <img src="../assets/samsungEVOSSD.png" alt="Product Image">
      <div class="product-info">
        <h3 class="product-title">Samsung EVO 870 SSD</h3>
        <p class="product-description">M.2 SSD PCIE 4.0 512GB | 1TB Storage</p>
        <p class="product-price">₱2,800</p>
        <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</a>
        <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
      </div>
    </div>
    <div class="product-card">
      <img src="../assets/lexarRAM.png" alt="Product Image">
      <div class="product-info">
        <h3 class="product-title">Lexar RAM </h3>
        <p class="product-description">8 GB | 16 GB | Gaming RAM 1600 | 2400 | 3200 | 3600 mhz</p>
        <p class="product-price">₱899</p>
        <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</a>
        <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
      </div>
    </div>
    
  </div>
<!-- New Arrivals Section -->
<h2 style="margin: 20px; font-size: 24px;" class="text-center" >NEW ARRIVALS</h2>
<div class="product-container">
  <div class="product-card">
    <img src="../assets/acerLaptop.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">Acer Aspire 7 A715-42G</h3>
      <p class="product-description">AMD Ryzen 7 5700U | NVIDIA GeForce RTX 3050 Ti</p>
      <p class="product-price">₱40,995.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/lenovoLAPTOP.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">Lenovo IdeaPad Slim 1 14ALC7</h3>
      <p class="product-description">AMD Ryzen 5 5500U | 16GB DDR4 RAM | Integrated AMD Radeon Graphics</p>
      <p class="product-price">₱33,499.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/hpLAPTOP.png" alt="Product Image" >
    <div class="product-info" >
      <h3 class="product-title">HP Pavilion Laptop 14-dv2097nr</h3>
      <p class="product-description">14 | Windows 11 Home | Intel®  Core™ i5 | 16GB RAM | 256GB SSD | FHD</p>
      <p class="product-price">₱38,699.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal"s>Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal"s>Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/asusLAPTOP.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">Asus 16" Vivobook Wuxga Laptop</h3>
      <p class="product-description">Intel I7-1255U 16gb/512gb Win11 Black</p>
      <p class="product-price">₱38,995.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <!-- You can add more New Arrival cards here -->
</div>

<!-- Top Sellers Section -->
<h2 style="margin: 20px; font-size: 24px;" class="text-center">TOP SELLERS</h2>
<div class="product-container">
  <div class="product-card">
    <img src="../assets/ak400.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">AK400 Digital CPU Cooler</h3>
      <p class="product-description">PWM 120mm Fan 1850RPM 220W TDP, Suitable for Intel LGA1700/1200/1151/1150/1155 AMD AM5/AM4</p>
      <p class="product-price">₱1,699.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/ryzen7.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">Ryzen 7 5700x</h3>
      <p class="product-description">8 Cores 16 Threads</p>
      <p class="product-price">₱8,500.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/rx6600.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">Gigabyte RX 6600 </h3>
      <p class="product-description">8GB GDDR6 128-bit Graphics</p>
      <p class="product-price">₱13,000.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <div class="product-card">
    <img src="../assets/lexarNVME.png" alt="Product Image">
    <div class="product-info">
      <h3 class="product-title">LEXAR NVME SSD 1TB</h3>
      <p class="product-description">NM710 1TB PCIe Gen4x4 NVMe M.2 SSD</p>
      <p class="product-price">₱3,100.00</p>
      <a href="#" class="product-button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signInModal">Add To Cart</a>
      <a href="#" class="product-button btn btn-success" data-bs-toggle="modal" data-bs-target="#signInModal">Buy Now</a>
    </div>
  </div>
  <!-- Add more Top Seller cards here -->
</div>

<div class="modal fade" id="signInModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You need to SignIn first.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../Authentication/signIn/login.php" class="btn btn-danger">
                        <i class="bi bi-check-lg me-2"></i>Sign In
                    </a>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-white py-4 mt-5 m" >
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