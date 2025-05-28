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
        <?php
        $categories = getProductsByCategory();
        foreach ($categories as $categoryId => $category):
        ?>
        <li class="list-group-item bg-dark text-white border-white">
            <?= htmlspecialchars($category['name']) ?>: 
            <span id="selected<?= $categoryId ?>">None</span>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="col-md-8 mb-4">
      <h4>Select Your Components</h4>
      <?php foreach ($categories as $categoryId => $category): ?>
      <div class="form-group mb-4">
        <label for="select<?= $categoryId ?>" class="form-label"><?= htmlspecialchars($category['name']) ?></label>
        <select class="form-select" id="select<?= $categoryId ?>" 
                onchange="updateSelection('<?= $categoryId ?>')" required>
            <option value="" data-price="0">-- Select <?= htmlspecialchars($category['name']) ?> --</option>
            <?php foreach ($category['products'] as $product): ?>
            <option value="<?= htmlspecialchars($product['name']) ?>" 
                    data-price="<?= $product['price'] ?>">
                <?= htmlspecialchars($product['name']) ?> - ₱<?= number_format($product['price'], 2) ?>
            </option>
            <?php endforeach; ?>
        </select>
      </div>
      <?php endforeach; ?>

      <div class="mt-4 text-end">
        <h5 class="text-start">Total: ₱<span id="totalPrice">0.00</span></h5>
        <button class="btn btn-warning mt-3"><i class="bi bi-cart me-2 "></i>Add To Cart</button>
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#buildSummaryModal">
          <i class="bi bi-bag me-2"></i>Buy Now
        </button>
      </div>
    </div>
  </div>
</div>



<!-- modals -->

<div class="modal fade" id="buildSummaryModal" tabindex="-1" aria-labelledby="buildSummaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="buildSummaryModalLabel">Build Summary</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>Category</th>
              <th>Selected Part</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody id="buildSummaryTableBody">
            <!-- Dynamically populated rows will go here -->
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">Total:</th>
              <th id="modalTotalPrice">₱0.00</th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success">Proceed to Checkout</button>
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
function updateSelection(categoryId) {
    const selectElement = document.getElementById('select' + categoryId);
    const selectedValue = selectElement.value;
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Update the selection display
    const displayElement = document.getElementById("selected" + categoryId);
    if (displayElement) {
        displayElement.textContent = selectedValue || "None";
        displayElement.parentElement.classList.toggle('text-success', selectedValue !== '');
    }
    
    // Update total price
    updateTotalPrice();
    
    // Update radar chart
    updateRadarChart();
}

function updateTotalPrice() {
    let total = 0;
    const selects = document.querySelectorAll('select[id^="select"]');
    
    selects.forEach(select => {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            total += parseFloat(selectedOption.dataset.price);
        }
    });
    
    document.getElementById('totalPrice').textContent = total.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function updateRadarChart() {
    const selects = document.querySelectorAll('select[id^="select"]');
    const data = Array.from(selects).map(select => select.selectedIndex);
    
    const chartData = {
        labels: Array.from(selects).map(select => select.previousElementSibling.textContent),
        datasets: [{
            label: "Performance",
            data: data,
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

// Initialize chart on page load
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("radarChart").getContext("2d");
    window.radarChartInstance = new Chart(ctx, {
        type: "radar",
        data: {
            labels: Array.from(document.querySelectorAll('select[id^="select"]')).map(
                select => select.previousElementSibling.textContent
            ),
            datasets: [{
                label: "Performance",
                data: new Array(document.querySelectorAll('select[id^="select"]').length).fill(0),
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

function updateSelection(categoryId) {
    const selectElement = document.getElementById('select' + categoryId);
    const selectedValue = selectElement.value;
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Update the selection display
    const displayElement = document.getElementById("selected" + categoryId);
    if (displayElement) {
        displayElement.textContent = selectedValue || "None";
        displayElement.parentElement.classList.toggle('text-success', selectedValue !== '');
    }
    
    // Update total price
    updateTotalPrice();
    
    // Update radar chart
    updateRadarChart();
}

// Function to update total price
function updateTotalPrice() {
    let total = 0;
    const selects = document.querySelectorAll('select[id^="select"]');
    
    selects.forEach(select => {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            total += parseFloat(selectedOption.dataset.price);
        }
    });
    
    document.getElementById('totalPrice').textContent = total.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Function to update radar chart
function updateRadarChart() {
    const selects = document.querySelectorAll('select[id^="select"]');
    const data = Array.from(selects).map(select => select.selectedIndex);
    
    const chartData = {
        labels: Array.from(selects).map(select => select.previousElementSibling.textContent),
        datasets: [{
            label: "Performance",
            data: data,
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

// Initialize radar chart on page load
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("radarChart").getContext("2d");
    window.radarChartInstance = new Chart(ctx, {
        type: "radar",
        data: {
            labels: Array.from(document.querySelectorAll('select[id^="select"]')).map(
                select => select.previousElementSibling.textContent
            ),
            datasets: [{
                label: "Performance",
                data: new Array(document.querySelectorAll('select[id^="select"]').length).fill(0),
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

// Update modal table dynamically when modal is opened
const buildSummaryModal = document.getElementById('buildSummaryModal');
buildSummaryModal.addEventListener('show.bs.modal', () => {
    const tbody = document.getElementById('buildSummaryTableBody');
    tbody.innerHTML = ''; // Clear existing rows
    
    let total = 0;
    const selects = document.querySelectorAll('select[id^="select"]');
    
    selects.forEach(select => {
        const selectedOption = select.options[select.selectedIndex];
        const category = select.previousElementSibling.textContent;
        const partName = selectedOption.value || 'None';
        const price = selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 0;

        // Append row
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${category}</td>
            <td>${partName}</td>
            <td>₱${price.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        `;
        tbody.appendChild(row);
        
        total += price;
    });
    
    document.getElementById('modalTotalPrice').textContent = '₱' + total.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
});

</script>
</body>
</html>

<?php
function getProductsByCategory() {
    global $conn;
    $categories = [];
    
    try {
        $result = $conn->query("CALL sp_get_pc_parts()");
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categoryId = $row['category_id'];
                
                if (!isset($categories[$categoryId])) {
                    $categories[$categoryId] = [
                        'name' => $row['category_name'],
                        'products' => []
                    ];
                }
                
                if ($row['product_id']) {
                    $categories[$categoryId]['products'][] = [
                        'id' => $row['product_id'],
                        'name' => $row['product_name'],
                        'price' => $row['price'],
                        'description' => $row['description'],
                        'image' => $row['image']
                    ];
                }
            }
        }
        return $categories;
    } catch (Exception $e) {
        error_log("Error calling sp_get_pc_parts: " . $e->getMessage());
        return [];
    }
}
?>
