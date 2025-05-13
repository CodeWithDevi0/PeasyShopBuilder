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
        <link rel="stylesheet" href="../guest/priceList.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        table, th, td {
    border:1px solid black;
    }
    th, td {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;
    padding-right: 40px;
    }
    </style>

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
    

    <ul class="nav fs-5 justify-content-center mt-2">
    <li class="nav-item nav-pills ">
        <a class="nav-link text-dark" href="index.php">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark" href="build.php">Build A PC</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark" href="laptops.php">Laptops</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark" href="computers.php">Computers</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active text-white bg-success" aria-current="page" href="priceList.php">Price List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled text-dark" aria-disabled="true">Disabled</a>
    </li>
    </ul>




    <div class="container my-4">
 


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
    

        <H2 class="text-center">Price List</H2>
        <a class="btn btn-success text-right" href="priceList.php" style="margin-left:94%;">Refresh
        </a>


        <div class="table-header mt-2">

            <table style="width: 100%; font-weight: 700;">
                <tr>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>SRP</th>
                    <th>Current Price</th>
                </tr>
                <tr>
                    <td>Processor</td>
                    <td>AMD</td>
                    <td>Ryzen 3 3200G</td>
                    <th>am4 3.6ghz</th>
                    <td>₱6,000</td>
                    <td>₱3,999</td>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>AMD</th>
                    <th>Ryzen 5 5600</th>
                    <th>6-Core, 12-Thread Unlocked</th>
                    <th>₱8,000</th>
                    <th>₱5,899</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>AMD</th>
                    <th>Ryzen 5 5600X</th>
                    <th>6-Core, 12-Thread Unlocked 3.7 GHz</th>
                    <th>₱9,000</th>
                    <th>₱6,500</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>AMD</th>
                    <th>Ryzen 5 5600G</th>
                    <th>6-Core, 12-Thread Desktop Processor with Radeon™ Graphics</th>
                    <th>₱9,500</th>
                    <th>₱6,000</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>AMD</th>
                    <th>Ryzen 5 5600GT</th>
                    <th>6-Core, 12-Thread Unlocked</th>
                    <th>₱8,000</th>
                    <th>₱6,899</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i3</th>
                    <th>10th Generation, Intel UHD</th>
                    <th>₱6,000</th>
                    <th>₱4,999</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i5</th>
                    <th>10th Generation 6-Core, 12-Thread Unlocked</th>
                    <th>₱10,000</th>
                    <th>₱7,500</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i5</th>
                    <th>12th Generation 6-Core, 12-Thread Unlocked</th>
                    <th>₱11,000</th>
                    <th>₱9,699</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i7</th>
                    <th>13700k 16 Cores (8-P Cores + 8-E Cores)</th>
                    <th>₱25,000</th>
                    <th>₱12,899</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i7</th>
                    <th>14700k 20 Cores (8-P Cores + 8-E Cores)</th>
                    <th>₱20,000</th>
                    <th>₱15,000</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Gigabyte</th>
                    <th>Gigabyte GTX 1650</th>
                    <th>D6 Windforce OC 4gb 128bit GDdr6 Gaming Videocard REV 2.0</th>
                    <th>₱15,000</th>
                    <th>₱9,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Gigabyte</th>
                    <th>Gigabyte RTX 3060</th>
                    <th>Gaming OC LHR R2.0 GV-N3060GAMING-OC-12GD-2.0 12gb 192bit GDdr6 Gaming Videocard RGB</th>
                    <th>₱35,000</th>
                    <th>₱22,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Gigabyte</th>
                    <th>Gigabyte Rx 6600 </th>
                    <th>Eagle GV-R66EAGLE-8GD 8gb 128bit GDdr6 Gaming Videocard</th>
                    <th>₱18,000</th>
                    <th>₱14,000</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Galax</th>
                    <th>Galax GTX 1650</th>
                    <th>EX Plus 1-Click OC 4gb 128bit GDdr6 Gaming Videocard</th>
                    <th>₱8,450</th>
                    <th>₱8,450</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Galax</th>
                    <th>Galax RTX 3060</th>
                    <th>1-Click OC 36NOL7MD1VOC 12gb 192bit GDdr6 Videocard LHR</th>
                    <th>₱25,000</th>
                    <th>₱17,450</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>MSI</th>
                    <th>MSI RTX 3070 Ti</th>
                    <th>Ventus 3X OC 8gb 256bit GDdr6X Gaming Videocard</th>
                    <th>₱45,000</th>
                    <th>₱38,000</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>MSI</th>
                    <th>MSI Gtx 1650</th>
                    <th>D6 Ventus XS OC V3 4gb 128bit GDdr6 Gaming Videocard</th>
                    <th>₱13,000</th>
                    <th>₱9,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>PALIT</th>
                    <th>PALIT GeForce RTX 3050</th>
                    <th>StormX NE63050018P1-1070F 8gb 128bit GDdr6 Gaming Videocard LHR</th>
                    <th>₱17,000</th>
                    <th>₱15,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>PALIT</th>
                    <th>PALIT GeForce RTX 3050</th>
                    <th>DUAL RGB NE63050018P1-1070D 8GB GDDR6 128BIT Videocard</th>
                    <th>₱17,000</th>
                    <th>₱16,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>Intel</th>
                    <th>Intel Core i9</th>
                    <th>14900k 16 Cores (8-P Cores + 8-E Cores)</th>
                    <th>₱35,000</th>
                    <th>₱29,899</th>
                </tr>
                <tr>
                    <th>Graphic Card</th>
                    <th>ASUS</th>
                    <th>Asus Rtx 3050</th>
                    <th>Dual OC Edition DUAL-RTX3050-O8G-V2 8gb 128bit GDdr6 Gaming Videocard LHR</th>
                    <th>₱35,000</th>
                    <th>₱29,899</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>MSI</th>
                    <th>MSI B450 Gaming</th>
                    <th>Plus Max Socket Am4 Ddr4 Motherboard</th>
                    <th>₱6,000</th>
                    <th>₱5,599</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>MSI</th>
                    <th>MSI B450M</th>
                    <th>Pro-Vdh Max Socket Am4 Ddr4 Motherboard</th>
                    <th>₱5,000</th>
                    <th>₱4,999</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>Gigabyte</th>
                    <th>Gigabyte H610M-H</th>
                    <th>V2 Socket LGA 1700 Ddr4 Motherboard</th>
                    <th>₱6,000</th>
                    <th>₱5,599</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>MSI</th>
                    <th>MSI B550M Pro</th>
                    <th>VDH Wifi Socket Am4 Ddr4 Motherboard</th>
                    <th>₱8,000</th>
                    <th>₱6,500</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>MSI</th>
                    <th>MSI A520m-A Pro</th>
                    <th>Socket Am4 Ddr4 Motherboard</th>
                    <th>₱5,000</th>
                    <th>₱4,500</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>ASUS</th>
                    <th>Asus Prime B550M-A Wifi II</th>
                    <th>Socket Am4 Ddr4 Gaming Motherboard</th>
                    <th>₱8,500</th>
                    <th>₱6,899</th>
                </tr>
                <tr>
                    <th>Motherboard</th>
                    <th>Asrock</th>
                    <th>Asrock B550M</th>
                    <th>Pro4 Socket Am4 Ddr4 Motherboard</th>
                    <th>₱8,000</th>
                    <th>₱6,599</th>
                </tr>
                <tr>
                    <th>Memory</th>
                    <th>Team</th>
                    <th>Team Elite 4gb 1x4</th>
                    <th>1600mhz Ddr3 with Heatspreader Memory</th>
                    <th>₱1,000</th>
                    <th>₱899</th>
                </tr>
                <tr>
                    <th>Memory</th>
                    <th>Kingston</th>
                    <th>Kingston Fury Beast KF432C16BB2A/8 8gb 1x8 </th>
                    <th>3200MT/s Ddr4 RGB Memory Black</th>
                    <th>₱1,500</th>
                    <th>₱1,599</th>
                </tr>
                <tr>
                    <th>Memory</th>
                    <th>Adata</th>
                    <th>Adata Gammix D30 8gb 1x8</th>
                    <th>3200mhz Ddr4 Memory Black</th>
                    <th>₱2,000</th>
                    <th>₱1,899</th>
                </tr>
                <tr>
                    <th>Memory</th>
                    <th>Skihotar</th>
                    <th>Skihotar 8GB 1x8 </th>
                    <th>3200mHz DDR4 Memory</th>
                    <th>₱1,500</th>
                    <th>₱1,299</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>G.Skill</th>
                    <th>Trident Z F4-3600C18D-32GTZR 32gb 2x16 </th>
                    <th>3600mhz Ddr4 RGB Memory</th>
                    <th>₱5,500</th>
                    <th>₱5,500</th>
                </tr>
                <tr>
                    <th>Memory</th>
                    <th>Lexar</th>
                    <th>Lexar Thor 8GB LD4BU008G-R3200GSXG 1x8</th>
                    <th>3200Mhz DDR4 Memory Dark Grey</th>
                    <th>₱1,500</th>
                    <th>₱1,299</th>
                </tr>
                <tr>
                    <th>Storage</th>
                    <th>Team</th>
                    <th>Group GX2 Solid State Drive</th>
                    <th>1tb SATA 2.5</th>
                    <th>₱5,000</th>
                    <th>₱4,599</th>
                </tr>
                <tr>
                    <th>Storage</th>
                    <th>Samsung</th>
                    <th>Samsung 870 Evo Solid State Drive</th>
                    <th>500gb SATA 2.5</th>
                    <th>₱4,500</th>
                    <th>₱3,599</th>
                </tr>
                <tr>
                    <th>Storage</th>
                    <th>Samsung</th>
                    <th>Intel Core i9</th>
                    <th>Samsung 870 EVO 1TB SATA 2.5 Solid State Drive</th>
                    <th>₱6,000</th>
                    <th>₱4,899</th>
                </tr>
                <tr>
                    <th>Storage</th>
                    <th>Kingston</th>
                    <th>Kingston SSDNow A400 Solid State Drive</th>
                    <th>480gb SATA 2.5	</th>
                    <th>₱3,000</th>
                    <th>₱2,899</th>
                </tr>
                <tr>
                    <th>Storage</th>
                    <th>Western Digital</th>
                    <th>Western Digital Solid State Drive </th>
                    <th>500gb Blue SATA 2.5	</th>
                    <th>₱5,000</th>
                    <th>₱3,399</th>
                </tr>
                <tr>
                    <th>Processor</th>
                    <th>Intel</th>
                    <th>Intel Core i9</th>
                    <th>14900k 16 Cores (8-P Cores + 8-E Cores)</th>
                    <th>₱35,000</th>
                    <th>₱29,899</th>
                </tr>
            </table>
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