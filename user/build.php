<?php
require_once '../database/database.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
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
    <link rel="stylesheet" href="profile.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">  
</head>
<body> 
<nav class="navbar navbar-expand-lg bg-success px-4 py-2">
  <div class="container-fluid">

    <a class="navbar-brand d-flex align-items-center text-white" href="#">
      <img src="../assets/nobg.png" alt="Logo" width="60" height="60" class="me-2">
      <strong>PEasy</strong>
    </a>


    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-bag fs-4"></i></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-chat-left fs-4"></i></a>
        </li>
        <li class="nav-item mx-2 ">
                        <a class="nav-link text-white d-flex align-items-center just"
                            href="<?php echo isset($_SESSION['user_logged_in']) ? 'profile.php' : 'profile.php'; ?>">
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

<ul class="nav fs-5 align-items-center justify-content-center nav-pills" id="pills-tab pills-success" role="tablist" style="margin-top: 8px;">
  <li class="nav-item">
    <a class="nav-link text-dark" href="../user/index.php" data-bs-toggle="modal" data-bs-target="#mainModal">Home</a>
  </li>
  <li class="nav-item nav-pills">
    <a class="nav-link active bg-success text-white" aria-current="page" href="../user/build.php">Build A PC</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="laptops.php">Laptops</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="computers.php">Computers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="../guest/priceList.php">Price List</a>
  <li class="nav-item">
    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
  </li>
</ul>

<h2 class="text-center mt-4"><b>BUILD YOUR OWN PC</b></h2>

<div class="container my-4 py-4">
  <div class="row">

    <div class="col-md-4 bg-dark text-white p-5 rounded">
      <h5>BUILD SUMMARY</h5>
      <canvas id="radarChart" width="300" height="10"></canvas>
      <ul class="list-group mt-3">
        <li class="list-group-item bg-dark text-white border-white">CPU: <span id="selectedCpu">None</span></li>
        <li class="list-group-item bg-dark text-white border-white">GPU: <span id="selectedGpu">None</span></li>
        <li class="list-group-item bg-dark text-white border-white">RAM: <span id="selectedRam">None</span></li>
        <li class="list-group-item bg-dark text-white border-white">Storage: <span id="selectedStorage">None</span></li>
        <li class="list-group-item bg-dark text-white border-white">PSU: <span id="selectedPsu">None</span></li>
        <li class="list-group-item bg-dark text-white border-white">Case: <span id="selectedCase">None</span></li>
      </ul>
    </div>

    <div class="col-md-8 mb-4">
      <h4>Select Your Components</h4>
      
      <div class="form-group mb-4 mt-4">
        <label for="cpuSelect" class="form-label">Processor</label>
        <select class="form-select" id="cpuSelect" onchange="updateSelection('cpu')" required>
          <option value="" data-price="0">-- Select CPU --</option>
          <option value="AMD RYZEN 3 3200G" data-price="4648">AMD RYZEN 3 3200G - ₱4,648</option>
          <option value="AMD Ryzen 5" data-price="5000">AMD RYZEN 5 5600 - ₱5,000</option>
          <option value="AMD RYZEN 5 5600X" data-price="5599">AMD RYZEN 5 5600X - ₱5,599</option>
          <option value="AMD RYZEN 5 5600G" data-price="6500">AMD RYZEN 5 5600G - ₱6,500</option>
          <option value="AMD RYZEN 5 5600GT " data-price="6999">AMD RYZEN 5 5600GT - ₱6,999</option>
          <option value="AMD RYZEN 5 8400F" data-price="7548">AMD RYZEN 5 8400F - ₱7,548</option>
          <option value="AMD RYZEN 7 5700X" data-price="9499">AMD RYZEN 7 5700X - ₱9,499</option>
          <option value="AMD RYZEN 7 5700G" data-price="10999">AMD RYZEN 7 5700G - ₱10,999</option>
          <option value="AMD RYZEN 7 9800X3D" data-price="25499">AMD RYZEN 7 9800X3D - ₱25,499</option>

        </select>
      </div>

      <div class="form-group mb-3">
        <label for="gpuSelect" class="form-label">Graphics Card</label>
        <select class="form-select" id="gpuSelect" onchange="updateSelection('gpu')" required>
          <option value="" data-price="0">-- Select GPU --</option>
          <option value="RX 580" data-price="7000">AMD RX 580 - ₱7,000</option>
          <option value="GTX 1050 Ti" data-price="8000">AMD GTX 1050 Ti - ₱8,000</option>
          <option value="GTX 1650 Super" data-price="10000">AMD GTX 1650 Super - ₱10,000</option>
          3<option value="GTX 1660 Ti" data-price="11000">AMD GTX 1660 Ti 6600 - ₱11,000</option>
          <option value="RX 6600" data-price="14000">AMD RX 6600 - ₱14,000</option>
          <option value="RX 6700 XT" data-price="15000">AMD RX 6700 XT - ₱15,000</option>
          <option value="RTX 3060 Ti" data-price="20000">AMD RTX 3060 Ti - ₱20,000</option>
          <option value="RTX 3060" data-price="22000">NVIDIA RTX 3060 - ₱22,000</option>
          <option value="RTX 5070 " data-price="40000">AMD RTX 5070 - ₱40,000</option>
          <option value="RTX 5080" data-price="55000">AMD RTX 5080 - ₱55,000</option>
          <option value="RTX 4090" data-price="98000">AMD RTX 4090 - ₱98,000</option>
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="ramSelect" class="form-label">RAM</label>
        <select class="form-select" id="ramSelect" onchange="updateSelection('ram')" required>
          <option value="" data-price="0">-- Select RAM --</option>
          <option value="Kingston 8GB DDR4 2400 mhz" data-price="750">Kingston 8GB DDR4 2400 mhz 1  - ₱700</option>
          <option value="Kingston 8GB DDR4 2600 mhz" data-price="850">Kingston 8GB DDR4 2600 mhz 1  - ₱850</option>
          <option value="Lexar 8GB DDR4 3200 mhz" data-price="1000">Lexar 8GB DDR4 3200 mhz 1  - ₱1,000</option>
          <option value="T-Force RGB 8GB DDR4 3200" data-price="1500">T-Force RGB 8GB DDR4 3200 mhz 1  - ₱1,500</option>
          <option value="ADATA Kingston 16 GB DDR4 3200 mhz" data-price="2250">ADATA Kingston 16 GB DDR4 3200 mhz (8+8) - ₱2,250</option>
          <option value="Lexar 16GB DDR4 3200 mhz" data-price="2500">Lexar 16GB DDR4 3200 mhz 1 - ₱2,500</option>
          <option value="ADATA Kingston 16 GB DDR4 3600 mhz" data-price="3000">ADATA Kingston 16 GB DDR4 3600 mhz (8+8) - ₱3,000</option>
          <option value="Corsair 16GB DDR4 1  3600 mhz" data-price="3500">Corsair 16GB DDR4 1  3600 mhz (8+8) - ₱3,500</option>
          <option value="ADATA 32GB DDR4 3200 mhz (16+16)" data-price="4500">ADATA 32GB DDR4 3200 mhz (16+16) - ₱4,500</option>
          <option value="Lexar 32GB DDR4 3600 mhz (16+16)" data-price="5299">Lexar 32GB DDR4 3600 mhz (16+16) - ₱5,299</option>
          <option value="Corsair 32GB DDR4 4200 mhz" data-price="6699">Corsair 32GB DDR4 4200 mhz 1 - ₱6,699</option>
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="storageSelect" class="form-label">Storage</label>
        <select class="form-select" id="storageSelect" onchange="updateSelection('storage')" required>
          <option value="" data-price="0">-- Select Storage --</option>
          <option value="RAMSTA 256 SSD" data-price="1299">RAMSTA 256 SSD - ₱1,299</option>
          <option value="Samsung EVO 860 512GB SSD" data-price="1500">Samsung EVO 860 512GB SSD - ₱1,500</option>
          <option value="RAMSTA 512 SSD" data-price="1699">RAMSTA 512 SSD - ₱1,699</option>
          <option value="KINGSTON 512 SSD" data-price="1699">KINGSTON 512 SSD - ₱1,699</option>
          <option value="Samsung EVO 870 512GB SSD" data-price="1800">Samsung EVO 870 512GB SSD - ₱1,800</option>
          <option value="LEXAR NVME M.2 512GB SSD" data-price="1900">LEXAR NVME M.2 512GB SSD - ₱1,900</option>
          <option value="ADATA 512 SSD" data-price="2000">ADATA 512 SSD - ₱2,000</option>
          <option value="Samsung EVO 860 1TB SSD" data-price="2500">Samsung EVO 860 1TB SSD - ₱2,500</option>
          <option value="Samsung EVO 860 1TB SSD" data-price="3000">Samsung EVO 860 1TB SSD - ₱3000</option>
          <option value="RAMSTA 1TB SSD" data-price="4500">RAMSTA 1TB SSD - ₱4,500</option>
          <option value="LEXAR NVME M.2 1TB SSD" data-price="3499">LEXAR NVME M.2 1TB SSD - ₱3,499</option>
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="psuSelect" class="form-label">Power Supply</label>
        <select class="form-select" id="psuSelect" onchange="updateSelection('psu')" required>
          <option value="" data-price="0">-- Select PSU --</option>
          <option value="Inplay Bronze Rated PSU 450W" data-price="500">Inplay Bronze Rated PSU 450W - ₱500</option>
          <option value="Inplay Bronze Rated PSU 550W " data-price="750">Inplay Bronze Rated PSU 550W - ₱750</option>
          <option value="Inplay Bronze Rated PSU 650W" data-price="950">Inplay Bronze Rated PSU 650W - ₱950</option>
          <option value="Inplay Bronze Rated PSU 750" data-price="1250">Inplay Bronze Rated PSU 750 - ₱1,250</option>
          <option value="Corsair Bronze Rated 80+ PSU 550W" data-price="2499">Corsair Bronze Rated 80+ PSU 550W - ₱2,499</option>
          <option value="Gigabyte Gold Rated 80+ PSU 550W" data-price="2500">Gigabyte Gold Rated 80+ PSU 550W - ₱2,500</option>
          <option value="Gigabyte Gold Rated 80+ PSU 650W" data-price="3200">Gigabyte Gold Rated 80+ PSU 650W - ₱3,200</option>
          <option value="Corsair Bronze Rated 80+ PSU 650W" data-price="3299">Corsair Bronze Rated 80+ PSU 650W - ₱3,299</option>
          <option value="Corsair Gold Rated 80+ PSU 550W" data-price="3699">Corsair Gold Rated 80+ PSU 550W - ₱3,699</option>
          <option value="Corsair Gold Rated 80+ PSU 550W" data-price="4299">Corsair Gold Rated 80+ PSU 550W - ₱4,299</option>
          <option value="Seasonic Platinum Rated 80+ PSU 650W" data-price="7699">Seasonic Platinum Rated 80+ PSU 650W - ₱7,699</option>
          <option value="Cooler Master Gold Rated 80+ 650W" data-price="8000">Cooler Master Gold Rated 80+ 650W - ₱8,000</option>
          <option value="ASUS ROG Gold Rated 80+ PSU 650W" data-price="8599">ASUS ROG Gold Rated 80+ PSU 650W - ₱8,599</option>
          <option value="Seasonic Platinum Rated 80+ PSU 750W" data-price="9599">Seasonic Platinum Rated 80+ PSU 750W - ₱9,599</option>
        </select>
      </div>


      <div class="form-group mb-3">
        <label for="caseSelect" class="form-label">PC Case</label>
        <select class="form-select" id="caseSelect" onchange="updateSelection('case')" required>
          <option value="" data-price="0">-- Select Case --</option>
          <option value="Inplay Mid Tower RGB" data-price="2500">Inplay Mid Tower RGB - ₱1,700</option>
          <option value="Inplay Mini Tower" data-price="1800">Inplay Mini Tower - ₱1,800</option>
          <option value="Segotep W1 Glass Panel Case" data-price="1800">Segotep W1 Glass Panel Case - ₱2,000</option>
          <option value="MSI Side Glass PanelTower Case " data-price="1800">MSI Side Glass PanelTower Case - ₱2,990</option>
          <option value="ROG Full Tower Case" data-price="1800">ROG Full Tower Case - ₱3,400</option>
          <option value="Rog Glass Panel Tower Case " data-price="1800">Rog Glass Panel Tower Case- ₱3,999</option>
          <option value="MSI Customize Wooden Mid Tower RGB Case" data-price="2500">MSI Customize Wooden Mid Tower RGB Case - ₱6,500</option>
        </select>
      </div>
      <div class="mt-4 text-end">
        <h5 class="text-start">Total: ₱<span id="totalPrice">0.00</span></h5>
        <button class="btn btn-secondary w-25 fs-5 mt-4">Add To Cart</button>
        <button class="btn btn-success w-25 fs-5 mt-4">Buy Now</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="mainModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Your progress won't be saved, Are you sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        <a href="index.php" class="btn btn-success">
                        <i class="bi bi-check-lg me-2"></i>Back to Home
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-VpGV...YOUR_HASH..." crossorigin="anonymous"></script>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="bootstrap-5.3.5-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>



<script>
function updateSelection(componentType) {
  const selectElement = document.getElementById(componentType + "Select");
  const selectedValue = selectElement.value;
  document.getElementById("selected" + capitalize(componentType)).textContent = selectedValue || "None";
  updateRadarChart(); 
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function updateRadarChart() {
  const chartData = {
    labels: ["CPU", "GPU", "RAM", "Storage", "PSU", "Case"],
    datasets: [{
      label: "Performance",
      data: [
        document.getElementById("cpuSelect").selectedIndex,
        document.getElementById("gpuSelect").selectedIndex,
        document.getElementById("ramSelect").selectedIndex,
        document.getElementById("storageSelect").selectedIndex,
        document.getElementById("psuSelect").selectedIndex,
        document.getElementById("caseSelect") ? document.getElementById("caseSelect").selectedIndex : 0
      ],
      backgroundColor: "rgba(40,167,69,0.4)",
      borderColor: "rgba(40,167,69,1)",
      borderWidth: 1
    }]
  };

  if (window.radarChartInstance) {
    window.radarChartInstance.data = chartData;
    window.radarChartInstance.update();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const ctx = document.getElementById("radarChart").getContext("2d");
  window.radarChartInstance = new Chart(ctx, {
    type: "radar",
    data: {
      labels: ["CPU", "GPU", "RAM", "Storage", "PSU", "Case"],
      datasets: [{
        label: "Performance",
        data: [0, 0, 0, 0, 0, 0],
        backgroundColor: "rgba(40,167,69,0.4)",
        borderColor: "rgba(40,167,69,1)",
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        r: {
          beginAtZero: true,
          max: 10
        }
      }
    }
  });
});
</script>
</body>
</html>
